<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$error = '';
$success = '';
$article = null;
$article_images = [];

// Handle Delete Individual Image
if (isset($_GET['delete_image']) && isset($_GET['id'])) {
    requireCsrfToken('GET', 'get');
    $img_id = (int)$_GET['delete_image'];
    $article_id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT image_path FROM article_images WHERE id = ? AND article_id = ?");
    $stmt->execute([$img_id, $article_id]);
    $img = $stmt->fetch();
    
    if ($img) {
        if (file_exists($img['image_path'])) {
            unlink($img['image_path']);
        }
        $pdo->prepare("DELETE FROM article_images WHERE id = ?")->execute([$img_id]);
        header("Location: news-add?id=" . $article_id . "&success=image_deleted");
        exit;
    }
}

if (isset($_GET['success']) && $_GET['success'] == 'image_deleted') {
    $success = "Image deleted successfully.";
}

// Handle Delete Draft from Widget
if (isset($_GET['delete_draft'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete_draft'];
    
    // Unlink files
    $stmt = $pdo->prepare("SELECT cover_image FROM news WHERE id = ? AND status = 'Draft'");
    $stmt->execute([$del_id]);
    $art = $stmt->fetch();
    if ($art && !empty($art['cover_image']) && file_exists($art['cover_image'])) {
        unlink($art['cover_image']);
    }
    
    $imgStmt = $pdo->prepare("SELECT image_path FROM article_images WHERE article_id = ?");
    $imgStmt->execute([$del_id]);
    while ($img = $imgStmt->fetch()) {
        if (!empty($img['image_path']) && file_exists($img['image_path'])) {
            unlink($img['image_path']);
        }
    }

    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ? AND status = 'Draft'");
    $stmt->execute([$del_id]);
    header("Location: news-add");
    exit;
}

// Check if editing
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM news WHERE id = ?");
    $stmt->execute([$id]);
    $article = $stmt->fetch();
    if (!$article) {
        header("Location: news");
        exit;
    }
    
    // Fetch additional images
    $imgStmt = $pdo->prepare("SELECT * FROM article_images WHERE article_id = ?");
    $imgStmt->execute([$id]);
    $article_images = $imgStmt->fetchAll();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrfToken('POST', 'post');
    $title = trim($_POST['title']);
    $title_si = trim($_POST['title_si'] ?? '');
    $title_ta = trim($_POST['title_ta'] ?? '');
    $content = trim($_POST['content']);
    $content_si = trim($_POST['content_si'] ?? '');
    $content_ta = trim($_POST['content_ta'] ?? '');
    $visibility = $_POST['visibility'] ?? 'public';
    $is_featured = ($_POST['is_featured'] ?? 'no') === 'yes' ? 1 : 0;
    
    // Check which button was clicked
    $status = isset($_POST['save_draft']) ? 'Draft' : 'Published';

    // File upload logic
    $cover_image = $article ? $article['cover_image'] : null;
    if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = handleFileUpload($_FILES['cover_image'], 'uploads/news');
        if ($uploadResult['success']) {
            if ($article && !empty($article['cover_image']) && file_exists($article['cover_image'])) {
                unlink($article['cover_image']);
            }
            $cover_image = $uploadResult['path'];
        } else {
            $error = $uploadResult['error'];
        }
    } elseif (!$article && $status !== 'Draft') {
        $error = "Cover image is required to publish.";
    }

    if (empty($title)) {
        $error = "Title is required.";
    }

    if ($status === 'Draft') {
        if (empty($content)) $content = '';
    } else {
        if (empty($content)) $error = "Content is required to publish.";
    }

    if (empty($error)) {
        try {
            if ($article) {
                $stmt = $pdo->prepare("UPDATE news SET title=?, title_si=?, title_ta=?, content=?, content_si=?, content_ta=?, cover_image=?, visibility=?, is_featured=?, status=? WHERE id=?");
                $success_db = $stmt->execute([$title, $title_si, $title_ta, $content, $content_si, $content_ta, $cover_image, $visibility, $is_featured, $status, $article['id']]);
                $article_id = $article['id'];
            } else {
                $stmt = $pdo->prepare("INSERT INTO news (title, title_si, title_ta, content, content_si, content_ta, cover_image, visibility, is_featured, status, author_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $success_db = $stmt->execute([$title, $title_si, $title_ta, $content, $content_si, $content_ta, $cover_image, $visibility, $is_featured, $status, $_SESSION['admin_id']]);
                $article_id = $pdo->lastInsertId();
            }

            if ($success_db) {
                $success = "News item " . ($status === 'Draft' ? "saved as draft." : "published successfully.");
                
                // Handle multiple images
                if (isset($_FILES['additional_images'])) {
                    foreach ($_FILES['additional_images']['tmp_name'] as $key => $tmp_name) {
                        if ($_FILES['additional_images']['error'][$key] === UPLOAD_ERR_OK) {
                            $file = [
                                'name' => $_FILES['additional_images']['name'][$key],
                                'type' => $_FILES['additional_images']['type'][$key],
                                'tmp_name' => $tmp_name,
                                'error' => $_FILES['additional_images']['error'][$key],
                                'size' => $_FILES['additional_images']['size'][$key],
                            ];
                            $uploadResult = handleFileUpload($file, 'uploads/news');
                            if ($uploadResult['success']) {
                                $imgPath = $uploadResult['path'];
                                $imgStmt = $pdo->prepare("INSERT INTO article_images (article_id, image_path) VALUES (?, ?)");
                                $imgStmt->execute([$article_id, $imgPath]);
                            }
                        }
                    }
                }
                header("Location: news");
                exit;
            } else {
                $error = "Failed to save news to database.";
            }
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage() . " - Please ensure your server database is up-to-date with your local changes.";
        }
    }
}

// Fetch recent drafts for the widget
$stmt = $pdo->prepare("SELECT id, title, created_at, status FROM news WHERE status = 'Draft' ORDER BY created_at DESC LIMIT 5");
$stmt->execute();
$recentDrafts = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900"><?= $article ? 'Edit News' : 'Add News' ?></h2>
            <a href="news" class="bg-white border border-[#4E0000] text-[#4E0000] px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-gray-50 transition-colors shadow-sm flex items-center">
                Back to News
            </a>
        </div>

        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm font-medium">
                <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="js-validate-form js-reset-on-success">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Form (Col 2) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Article Title -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[13px] font-semibold text-gray-800">News Title (English) <span class="text-red-500">*</span></label>
                            <button type="button" onclick="autoTranslateTitle()" id="translate-title-btn" class="text-[12px] bg-blue-50 text-blue-600 px-3 py-1 rounded border border-blue-100 hover:bg-blue-100 transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                Auto Translate Title
                            </button>
                        </div>
                        <input type="text" id="title_en" name="title" required value="<?= $article ? htmlspecialchars($article['title']) : '' ?>" placeholder="Enter news headline" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                    </div>

                    <!-- Translated Titles -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Title (Sinhala)</label>
                            <input type="text" id="title_si" name="title_si" style="font-family: 'Noto Sans Sinhala', sans-serif;" value="<?= $article && isset($article['title_si']) ? htmlspecialchars($article['title_si']) : '' ?>" placeholder="Sinhala translation" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Title (Tamil)</label>
                            <input type="text" id="title_ta" name="title_ta" style="font-family: 'Noto Sans Tamil', sans-serif;" value="<?= $article && isset($article['title_ta']) ? htmlspecialchars($article['title_ta']) : '' ?>" placeholder="Tamil translation" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                    </div>


                    <!-- Full Article Body -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-[13px] font-semibold text-gray-800">News Body (English) <span class="text-red-500">*</span></label>
                            <button type="button" onclick="autoTranslateBody()" id="translate-body-btn" class="text-[12px] bg-blue-50 text-blue-600 px-3 py-1 rounded border border-blue-100 hover:bg-blue-100 transition-colors flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                Auto Translate Body
                            </button>
                        </div>
                        <input type="hidden" name="content" id="content_en_input">
                        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                            <div id="content_en" style="height: 250px;"><?= $article ? $article['content'] : '' ?></div>
                        </div>
                    </div>

                    <!-- Translated Bodies -->
                    <div class="space-y-6 mt-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Body (Sinhala)</label>
                            <input type="hidden" name="content_si" id="content_si_input">
                            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                                <div id="content_si" style="height: 200px;"><?= $article && isset($article['content_si']) ? $article['content_si'] : '' ?></div>
                            </div>
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Body (Tamil)</label>
                            <input type="hidden" name="content_ta" id="content_ta_input">
                            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                                <div id="content_ta" style="height: 200px;"><?= $article && isset($article['content_ta']) ? $article['content_ta'] : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Cover Image <?= !$article ? '<span class="text-red-500">*</span>' : '' ?></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-secondary transition-colors cursor-pointer bg-[#F9FAFB]" onclick="document.getElementById('cover_image').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-[13px] text-gray-600 justify-center mt-2">
                                    <span class="relative cursor-pointer rounded-md font-medium text-secondary hover:text-[#320000] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary">
                                        <span>Upload a file</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" <?= !$article ? 'required' : '' ?> onchange="previewSingleImage(this, 'cover-preview')">
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 5MB</p>
                            </div>
                        </div>
                        <div id="cover-preview" class="mt-4 flex gap-4 flex-wrap">
                            <?php if ($article && $article['cover_image']): ?>
                                <div class="relative group">
                                    <img loading="lazy" src="<?= htmlspecialchars($article['cover_image']) ?>" class="h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Additional Images -->
                    <div>
                        <label class="block text-[13px] font-semibold text-gray-800 mb-2">Additional Images (Optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-xl hover:border-secondary transition-colors cursor-pointer bg-[#F9FAFB]" onclick="document.getElementById('additional_images').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-[13px] text-gray-600 justify-center mt-2">
                                    <span class="relative cursor-pointer rounded-md font-medium text-secondary hover:text-[#320000] focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-secondary">
                                        <span>Upload files</span>
                                        <input id="additional_images" name="additional_images[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewMultipleImages(this, 'additional-preview')">
                                    </span>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP (multiple allowed)</p>
                            </div>
                        </div>
                        <div id="additional-preview" class="mt-4 flex gap-4 flex-wrap">
                            <?php if ($article_images): ?>
                                <?php foreach($article_images as $img): ?>
                                    <div class="relative group">
                                        <img loading="lazy" src="<?= htmlspecialchars($img['image_path']) ?>" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                                        <a href="news-add?id=<?= $article['id'] ?>&delete_image=<?= $img['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Delete this image?')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 justify-between items-stretch sm:items-center pt-4">
                        <div>
                            <?php if ($article): ?>
                                <a href="news?delete=<?= $article['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to delete this news item?');" class="w-full sm:w-auto px-4 py-2 border border-red-200 text-red-500 hover:bg-red-50 rounded-md text-[13px] font-bold transition-colors inline-flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3">
                            <button type="submit" name="save_draft" value="1" formnovalidate class="js-save-draft w-full sm:w-auto px-6 py-2.5 border border-[#4E0000] text-[#4E0000] rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors bg-white">
                                Save as Draft
                            </button>
                            <button type="submit" name="publish" value="1" class="w-full sm:w-auto px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                                Publish News
                            </button>
                        </div>
                    </div>

                </div> <!-- End Main Form wrapper, sidebar starts outside form -->

            <!-- Right Column: Sidebar Widgets (Col 1) -->
            <div class="space-y-8">
                <!-- Publish Options Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Publish Options</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Visibility -->
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Visibility <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <select name="visibility" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="Public" <?= ($article && $article['visibility'] === 'public') ? 'selected' : '' ?>>Public</option>
                                    <option value="Private" <?= ($article && $article['visibility'] === 'private') ? 'selected' : '' ?>>Private</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Featured Article (Only for Notices) -->
                        <div id="featured-block" style="display: none;">
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">Featured Notice?</label>
                            <div class="relative">
                                <select name="is_featured" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                    <option value="no" <?= ($article && $article['is_featured'] == 0) ? 'selected' : '' ?>>No</option>
                                    <option value="yes" <?= ($article && $article['is_featured'] == 1) ? 'selected' : '' ?>>Yes</option>
                                </select>
                                <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Recent Drafts Widget -->
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Recent Drafts</h3>
                    </div>
                    <div class="p-6">
                        <?php if(empty($recentDrafts)): ?>
                            <p class="text-[13px] text-gray-500">No recent drafts.</p>
                        <?php else: ?>
                            <?php foreach($recentDrafts as $draft): ?>
                            <div class="flex items-start justify-between gap-2 mb-4 group relative border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                <a href="news-add?id=<?= $draft['id'] ?>" class="flex flex-col gap-1.5 cursor-pointer flex-1">
                                    <h4 class="font-semibold text-gray-900 text-[13px] group-hover:text-[#4E0000] transition-colors leading-snug"><?= htmlspecialchars($draft['title'] ?: 'Untitled Draft') ?></h4>
                                    <p class="text-[11px] text-gray-500">Last edited <?= date('M d, Y', strtotime($draft['created_at'])) ?></p>
                                    <div class="mt-1">
                                        <span class="px-3 py-1 rounded bg-[#FCF1F2] text-[#9E212D] text-[11px] font-bold">Draft</span>
                                    </div>
                                </a>
                                <a href="news-add?delete_draft=<?= $draft['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="return confirm('Are you sure you want to delete this draft?');" class="text-gray-400 hover:text-red-500 p-1.5 rounded hover:bg-red-50 transition-colors" title="Delete Draft">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </main>
</div>

        <!-- Include Quill JS -->
        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
        
        <script>
        // Initialize Quill editors
        const quillOptions = {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link', 'image'],
                    ['clean']
                ]
            }
        };
        const quillEn = new Quill('#content_en', quillOptions);
        const quillSi = new Quill('#content_si', quillOptions);
        const quillTa = new Quill('#content_ta', quillOptions);

        // Sync Quill content to hidden inputs on form submit
        const form = document.querySelector('.js-validate-form');
        if (form) {
            form.addEventListener('submit', function() {
                // Only save if it's not totally empty (Quill default empty is <p><br></p>)
                const enHtml = quillEn.root.innerHTML;
                const siHtml = quillSi.root.innerHTML;
                const taHtml = quillTa.root.innerHTML;
                
                document.getElementById('content_en_input').value = (enHtml === '<p><br></p>') ? '' : enHtml;
                document.getElementById('content_si_input').value = (siHtml === '<p><br></p>') ? '' : siHtml;
                document.getElementById('content_ta_input').value = (taHtml === '<p><br></p>') ? '' : taHtml;
            });
        }
        </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category-select');
    const featuredBlock = document.getElementById('featured-block');
    
    function updateFeaturedVisibility() {
        if (categorySelect.value === 'Notices') {
            featuredBlock.style.display = 'block';
        } else {
            featuredBlock.style.display = 'none';
            // Reset to no when hidden
            featuredBlock.querySelector('select').value = 'no';
        }
    }
    
    categorySelect.addEventListener('change', updateFeaturedVisibility);
    
    // Run on load
    updateFeaturedVisibility();
});

window.previewSingleImage = function(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<div class="relative group"><img loading="lazy" src="${e.target.result}" class="h-32 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-xs font-bold px-2 text-center">New Image</span></div></div>`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

window.previewMultipleImages = function(input, previewId) {
    const preview = document.getElementById(previewId);
    let html = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e) {
                html += `<div class="relative group"><img loading="lazy" src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-[10px] font-bold px-1 text-center">New</span></div></div>`;
                preview.innerHTML = html;
            }
            reader.readAsDataURL(file);
        });
    }
}

async function translateText(text, fromLang, toLang) {
    if (!text) return '';
    const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=${fromLang}&tl=${toLang}&dt=t&q=${encodeURIComponent(text)}`);
    const data = await res.json();
    return data[0].map(x => x[0]).join('');
}

async function autoTranslateTitle() {
    const titleEn = document.getElementById('title_en').value;
    if (!titleEn) {
        alert('Please enter English title to translate.');
        return;
    }

    const translateBtn = document.getElementById('translate-title-btn');
    const originalText = translateBtn.innerHTML;
    translateBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Translating...';
    translateBtn.disabled = true;

    try {
        const titleSi = await translateText(titleEn, 'en', 'si');
        document.getElementById('title_si').value = titleSi;
        
        const titleTa = await translateText(titleEn, 'en', 'ta');
        document.getElementById('title_ta').value = titleTa;
    } catch (err) {
        alert('Title translation failed. Please try again or enter manually.');
        console.error(err);
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}

async function autoTranslateBody() {
    const contentEn = quillEn.getText().trim();
    if (!contentEn) {
        alert('Please enter English content to translate.');
        return;
    }

    const translateBtn = document.getElementById('translate-body-btn');
    const originalText = translateBtn.innerHTML;
    translateBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Translating...';
    translateBtn.disabled = true;

    try {
        const contentSi = await translateText(contentEn, 'en', 'si');
        quillSi.setText(contentSi + '\n');
        
        const contentTa = await translateText(contentEn, 'en', 'ta');
        quillTa.setText(contentTa + '\n');
    } catch (err) {
        alert('Body translation failed. Please try again or enter manually.');
        console.error(err);
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}
</script>

<?php include 'includes/footer.php'; ?>
