<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_news');

$error = '';
$success = '';
$article = null;
$article_images = [];

// Handle Delete Individual Image
if (isset($_GET['delete_image']) && isset($_GET['id'])) {
    requireCsrfToken('GET', 'get');
    $img_id = (int)$_GET['delete_image'];
    $article_id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT image_path FROM news_images WHERE id = ? AND news_id = ?");
    $stmt->execute([$img_id, $article_id]);
    $img = $stmt->fetch();
    
    if ($img) {
        if (file_exists($img['image_path'])) {
            unlink($img['image_path']);
        }
        $pdo->prepare("DELETE FROM news_images WHERE id = ?")->execute([$img_id]);
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
    
    $imgStmt = $pdo->prepare("SELECT image_path FROM news_images WHERE news_id = ?");
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
    $imgStmt = $pdo->prepare("SELECT * FROM news_images WHERE news_id = ?");
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
    $visibility = strtolower($_POST['visibility'] ?? 'public');
    
    // Check which button was clicked
    if (isset($_POST['save_draft'])) {
        $status = 'Draft';
    } elseif (isset($_POST['submit_approval'])) {
        $status = 'Pending Approval';
    } else {
        $status = hasPermission('approve_news') ? 'Published' : 'Pending Approval';
    }

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
                $stmt = $pdo->prepare("UPDATE news SET title=?, title_si=?, title_ta=?, content=?, content_si=?, content_ta=?, cover_image=?, visibility=?, status=? WHERE id=?");
                $success_db = $stmt->execute([$title, $title_si, $title_ta, $content, $content_si, $content_ta, $cover_image, $visibility, $status, $article['id']]);
                $article_id = $article['id'];
            } else {
                $stmt = $pdo->prepare("INSERT INTO news (title, title_si, title_ta, content, content_si, content_ta, cover_image, visibility, status, author_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $success_db = $stmt->execute([$title, $title_si, $title_ta, $content, $content_si, $content_ta, $cover_image, $visibility, $status, $_SESSION['admin_id']]);
                $article_id = $pdo->lastInsertId();
            }

            if ($success_db) {
                $success = "News item " . ($status === 'Draft' ? "saved as draft." : ($status === 'Pending Approval' ? "submitted for approval." : "published successfully."));
                
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
                                $imgStmt = $pdo->prepare("INSERT INTO news_images (news_id, image_path) VALUES (?, ?)");
                                $imgStmt->execute([$article_id, $imgPath]);
                            }
                        }
                    }
                }
                header("Location: news?success=saved");
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
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 bg-[#F8F9FA]">
        <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        
        <?php if (!empty($success)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof window.showToast === 'function') {
                        window.showToast("<?= htmlspecialchars(addslashes($success)) ?>", "success");
                    }
                });
            </script>
        <?php endif; ?>

        <?php if (!empty($error)): ?>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    if (typeof window.showToast === 'function') {
                        window.showToast("<?= htmlspecialchars(addslashes($error)) ?>", "error");
                    }
                });
            </script>
        <?php endif; ?>

        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight"><?= $article ? 'Edit News' : 'Add News' ?></h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Create and publish news articles and announcements for the portal.</p>
            </div>
            <a href="news" class="group bg-white border border-slate-200 hover:border-secondary/30 text-slate-600 hover:text-secondary px-4 py-2 rounded-xl text-[12.5px] font-bold hover:bg-secondary/5 transition-all flex items-center gap-1.5 shadow-sm">
                <svg class="w-4 h-4 text-slate-450 group-hover:text-secondary group-hover:-translate-x-0.5 transition-all" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" /></svg>
                Back to News
            </a>
        </div>

        <?php if ($article && $article['status'] === 'Published' && !hasPermission('approve_news')): ?>
            <div class="max-w-7xl mx-auto mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 flex items-start gap-3 text-[13px] font-medium shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-amber-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                <div>
                    <strong class="block font-bold text-amber-900 mb-0.5">Editing a Published Article</strong>
                    Any changes you make will require approval. Saving will unpublish this article and return it to "Pending Approval" status.
                </div>
            </div>
        <?php endif; ?>

        <form action="" method="POST" enctype="multipart/form-data" class="js-validate-form js-reset-on-success">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column: Main Form (Col 2) -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Language Tabs -->
                    <div class="inline-flex p-1 bg-slate-100/80 backdrop-blur-md rounded-2xl mb-6 shadow-inner border border-slate-200/40 relative">
                        <button type="button" class="lang-tab-btn active px-6 py-2.5 text-[13px] font-bold rounded-xl text-secondary bg-white shadow-sm transition-all focus:outline-none relative z-10" data-target="lang-en">
                            English
                        </button>
                        <button type="button" class="lang-tab-btn px-6 py-2.5 text-[13px] font-semibold rounded-xl text-slate-500 hover:text-slate-800 transition-all focus:outline-none relative z-10 hover:bg-slate-50/50" data-target="lang-si">
                            Sinhala
                        </button>
                        <button type="button" class="lang-tab-btn px-6 py-2.5 text-[13px] font-semibold rounded-xl text-slate-500 hover:text-slate-800 transition-all focus:outline-none relative z-10 hover:bg-slate-50/50" data-target="lang-ta">
                            Tamil
                        </button>
                    </div>

                    <!-- English Tab -->
                    <div id="lang-en" class="lang-tab-content block">
                        <div class="space-y-6">
                            <div>
                                <div class="flex justify-between items-center mb-2">
                                    <label class="block text-[13px] font-semibold text-gray-800">News Title (English) <span class="text-red-500">*</span></label>
                                    <button type="button" onclick="autoTranslateTitle()" id="translate-title-btn" class="text-[12px] bg-blue-50 text-blue-600 px-3 py-1 rounded border border-blue-100 hover:bg-blue-100 transition-colors flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>
                                        Auto Translate Title
                                    </button>
                                </div>
                                <input type="text" id="title_en" name="title" required value="<?= $article ? htmlspecialchars($article['title']) : '' ?>" placeholder="Enter news headline" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px] text-gray-900 placeholder-gray-400">
                            </div>
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
                                    <div id="content_en" style="height: 300px;"><?= $article ? $article['content'] : '' ?></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sinhala Tab -->
                    <div id="lang-si" class="lang-tab-content hidden space-y-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Title (Sinhala)</label>
                            <input type="text" id="title_si" name="title_si" style="font-family: 'Noto Sans Sinhala', sans-serif;" value="<?= $article && isset($article['title_si']) ? htmlspecialchars($article['title_si']) : '' ?>" placeholder="Sinhala translation" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Body (Sinhala)</label>
                            <input type="hidden" name="content_si" id="content_si_input">
                            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                                <div id="content_si" style="height: 300px;"><?= $article && isset($article['content_si']) ? $article['content_si'] : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Tamil Tab -->
                    <div id="lang-ta" class="lang-tab-content hidden space-y-6">
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Title (Tamil)</label>
                            <input type="text" id="title_ta" name="title_ta" style="font-family: 'Noto Sans Tamil', sans-serif;" value="<?= $article && isset($article['title_ta']) ? htmlspecialchars($article['title_ta']) : '' ?>" placeholder="Tamil translation" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px] text-gray-900 placeholder-gray-400">
                        </div>
                        <div>
                            <label class="block text-[13px] font-semibold text-gray-800 mb-2">News Body (Tamil)</label>
                            <input type="hidden" name="content_ta" id="content_ta_input">
                            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                                <div id="content_ta" style="height: 300px;"><?= $article && isset($article['content_ta']) ? $article['content_ta'] : '' ?></div>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image -->
                    <div>
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Cover Image <?= !$article ? '<span class="text-red-500">*</span>' : '' ?></label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-primary transition-all duration-150 cursor-pointer bg-slate-50/50" onclick="document.getElementById('cover_image').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex text-[13px] text-slate-600 justify-center mt-2">
                                    <span class="relative cursor-pointer rounded-md font-bold text-primary hover:text-[#254974] focus-within:outline-none">
                                        <span>Upload a file</span>
                                        <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" <?= !$article ? 'required' : '' ?> onchange="previewSingleImage(this, 'cover-preview')">
                                    </span>
                                    <p class="pl-1 text-slate-400">or drag and drop</p>
                                </div>
                                <p class="text-xs text-slate-400 mt-1">PNG, JPG, WEBP up to 5MB</p>
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
                        <label class="block text-[13px] font-semibold text-slate-700 mb-2">Additional Images (Optional)</label>
                        <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-primary transition-all duration-150 cursor-pointer bg-slate-50/50" onclick="document.getElementById('additional_images').click()">
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-10 w-10 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <div class="flex text-[13px] text-slate-600 justify-center mt-2">
                                    <span class="relative cursor-pointer rounded-md font-bold text-primary hover:text-[#254974] focus-within:outline-none">
                                        <span>Upload files</span>
                                        <input id="additional_images" name="additional_images[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewMultipleImages(this, 'additional-preview')">
                                    </span>
                                    <p class="pl-1 text-slate-400">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, WEBP up to 5MB each (multiple allowed)</p>
                            </div>
                        </div>
                        <div class="mt-4 flex gap-4 flex-wrap">
                            <?php if ($article_images): ?>
                                <?php foreach($article_images as $img): ?>
                                    <div class="relative group">
                                        <img loading="lazy" src="<?= htmlspecialchars($img['image_path']) ?>" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                                        <a href="news-add?id=<?= $article['id'] ?>&delete_image=<?= $img['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Delete this image?" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </a>
                                    </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <div id="additional-preview" class="flex gap-4 flex-wrap"></div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="sticky bottom-4 z-50 bg-white/80 backdrop-blur-xl p-4 rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.08)] border border-white/50 flex flex-col sm:flex-row gap-4 justify-between items-center mt-8 ring-1 ring-slate-900/5">
                        <div>
                            <?php if ($article): ?>
                                <a href="news?delete=<?= $article['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this news item?" class="w-full sm:w-auto px-4 py-2 border border-rose-200/60 text-rose-500 hover:bg-rose-50 rounded-xl text-[13px] font-bold transition-all inline-flex items-center justify-center">
                                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    Delete Article
                                </a>
                            <?php endif; ?>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                            <a href="news" data-confirm="Are you sure you want to cancel? Any unsaved changes will be lost." class="w-full sm:w-auto px-6 py-2.5 border border-slate-200 text-slate-600 rounded-xl text-[13px] font-bold hover:bg-slate-50 transition-all bg-white text-center flex items-center justify-center shadow-sm">
                                Cancel
                            </a>
                            <?php if (!$article || $article['status'] === 'Draft' || $article['status'] === 'Pending Approval'): ?>
                            <button type="submit" name="save_draft" value="1" formnovalidate class="js-save-draft w-full sm:w-auto px-6 py-2.5 border border-slate-200 text-slate-700 rounded-xl text-[13px] font-bold hover:bg-slate-50 hover:text-secondary hover:border-secondary/30 transition-all bg-white shadow-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                <?= $article ? 'Save Draft' : 'Save as Draft' ?>
                            </button>
                            <?php endif; ?>
                            <?php if (hasPermission('approve_news')): ?>
                            <button type="submit" name="publish" value="1" class="relative group w-full sm:w-auto px-8 py-2.5 bg-gradient-to-r from-secondary to-[#6a0000] text-white rounded-xl text-[13px] font-bold hover:shadow-[0_8px_20px_rgba(78,0,0,0.3)] transition-all flex items-center justify-center gap-2 overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out"></div>
                                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                <span class="relative z-10"><?= $article && $article['status'] === 'Published' ? 'Update News' : 'Publish News' ?></span>
                            </button>
                            <?php else: ?>
                            <button type="submit" name="submit_approval" value="1" class="relative group w-full sm:w-auto px-8 py-2.5 bg-gradient-to-r from-blue-600 to-blue-800 text-white rounded-xl text-[13px] font-bold hover:shadow-[0_8px_20px_rgba(37,99,235,0.3)] transition-all flex items-center justify-center gap-2 overflow-hidden">
                                <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-in-out"></div>
                                <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span class="relative z-10"><?= $article && $article['status'] === 'Pending Approval' ? 'Update Request' : 'Submit for Approval' ?></span>
                            </button>
                            <?php endif; ?>
                        </div>
                    </div>

                </div> <!-- End Main Form wrapper, sidebar starts outside form -->

            <!-- Right Column: Sidebar Widgets (Col 1) -->
            <div class="space-y-6">
                <!-- Publish Options Widget -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_rgb(0,0,0,0.02)] overflow-hidden">
                    <div class="bg-slate-50/80 border-b border-slate-100 text-slate-800 p-5 backdrop-blur-sm">
                        <h3 class="font-bold font-montserrat text-[14px] flex items-center gap-2">
                            <svg class="w-4 h-4 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Publish Options
                        </h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <!-- Visibility -->
                        <div>
                            <label class="block text-[13px] font-semibold text-slate-700 mb-2">Visibility <span class="text-red-500">*</span></label>
                            <?php
                            $visSel = ($article && isset($article['visibility'])) ? $article['visibility'] : 'public';
                            echo renderDropdown([
                                'name' => 'visibility',
                                'options' => ['public' => 'Public', 'private' => 'Private'],
                                'selected' => $visSel,
                                'placeholder' => false,
                                'required' => true,
                                'context' => 'form',
                                'width' => 'w-full'
                            ]);
                            ?>
                        </div>

                        </div>
                    </div>
                </div>


                <!-- Recent Drafts Widget -->
                <div class="bg-white rounded-2xl border border-slate-100 shadow-[0_2px_10px_rgb(0,0,0,0.02)] overflow-hidden">
                    <div class="bg-slate-50/80 border-b border-slate-100 text-slate-800 p-5 backdrop-blur-sm">
                        <h3 class="font-bold font-montserrat text-[14px] flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            Recent Drafts
                        </h3>
                    </div>
                    <div class="p-6">
                        <?php if(empty($recentDrafts)): ?>
                            <p class="text-[13px] text-gray-500">No recent drafts.</p>
                        <?php else: ?>
                            <?php foreach($recentDrafts as $draft): ?>
                            <div class="flex items-start justify-between gap-2 mb-4 group relative border-b border-slate-50 pb-4 last:border-0 last:pb-0">
                                <a href="news-add?id=<?= $draft['id'] ?>" class="flex flex-col gap-1.5 cursor-pointer flex-1">
                                    <h4 class="font-bold text-slate-800 text-[13px] group-hover:text-secondary transition-colors leading-snug"><?= htmlspecialchars($draft['title'] ?: 'Untitled Draft') ?></h4>
                                    <p class="text-[11px] text-slate-400">Last edited <?= date('M d, Y', strtotime($draft['created_at'])) ?></p>
                                    <div class="mt-1">
                                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-600 border border-slate-200 uppercase tracking-wider font-mono">Draft</span>
                                    </div>
                                </a>
                                <a href="news-add?delete_draft=<?= $draft['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this draft?" class="text-slate-400 hover:text-rose-600 p-1.5 rounded-lg hover:bg-rose-50 transition-colors" title="Delete Draft">
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
        window.syncQuillToHidden = function() {
            const enHtml = quillEn.root.innerHTML;
            const siHtml = quillSi.root.innerHTML;
            const taHtml = quillTa.root.innerHTML;
            
            document.getElementById('content_en_input').value = (enHtml === '<p><br></p>') ? '' : enHtml;
            document.getElementById('content_si_input').value = (siHtml === '<p><br></p>') ? '' : siHtml;
            document.getElementById('content_ta_input').value = (taHtml === '<p><br></p>') ? '' : taHtml;
        };

        const form = document.querySelector('.js-validate-form');
        if (form) {
            form.addEventListener('submit', window.syncQuillToHidden);
        }

window.previewSingleImage = function(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            if (typeof window.showToast === 'function') {
                window.showToast('Cover image size exceeds the maximum limit of 5MB.', 'error');
            } else {
                alert('Cover image size exceeds the maximum limit of 5MB.');
            }
            input.value = ''; // clear selection
            return;
        }
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<div class="relative group"><img loading="lazy" src="${e.target.result}" class="h-32 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-xs font-bold px-2 text-center">New Image</span></div></div>`;
        }
        reader.readAsDataURL(file);
    }
}

let selectedAdditionalFiles = [];

window.previewMultipleImages = function(input, previewId) {
    const preview = document.getElementById(previewId);
    if (!input.files) return;

    const maxSize = 5 * 1024 * 1024; // 5MB
    let newFiles = Array.from(input.files);
    let hasLargeFile = false;
    let acceptedFiles = [];

    newFiles.forEach(file => {
        if (file.size > maxSize) {
            hasLargeFile = true;
        } else {
            acceptedFiles.push(file);
        }
    });

    if (hasLargeFile) {
        if (typeof window.showToast === 'function') {
            window.showToast('One or more selected images exceed the maximum limit of 5MB and were skipped.', 'error');
        } else {
            alert('One or more selected images exceed the maximum limit of 5MB and were skipped.');
        }
    }

    selectedAdditionalFiles = selectedAdditionalFiles.concat(acceptedFiles);
    
    syncAdditionalFilesInput(input);
    renderAdditionalPreviews(preview, input);
}

function syncAdditionalFilesInput(input) {
    if (typeof DataTransfer === 'undefined') return;
    const dt = new DataTransfer();
    selectedAdditionalFiles.forEach(file => dt.items.add(file));
    input.files = dt.files;
}

function renderAdditionalPreviews(previewDiv, input) {
    previewDiv.innerHTML = '';
    
    selectedAdditionalFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const itemDiv = document.createElement('div');
            itemDiv.className = 'relative group';
            itemDiv.innerHTML = `
                <img loading="lazy" src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                    <span class="text-white text-[10px] font-bold px-1 text-center">New</span>
                </div>
                <button type="button" onclick="removeAdditionalFile(${index}, '${previewDiv.id}', '${input.id}')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            `;
            previewDiv.appendChild(itemDiv);
        }
        reader.readAsDataURL(file);
    });
}

window.removeAdditionalFile = function(index, previewId, inputId) {
    selectedAdditionalFiles.splice(index, 1);
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    
    syncAdditionalFilesInput(input);
    renderAdditionalPreviews(preview, input);
}

async function translateText(text, fromLang, toLang) {
    if (!text) return '';
    const res = await fetch(`https://translate.googleapis.com/translate_a/single?client=gtx&sl=${fromLang}&tl=${toLang}&dt=t&q=${encodeURIComponent(text)}`);
    const data = await res.json();
    return data[0].map(x => x[0]).join('');
}

// Tab Switching Logic
document.addEventListener('DOMContentLoaded', function() {
    const tabBtns = document.querySelectorAll('.lang-tab-btn');
    const tabContents = document.querySelectorAll('.lang-tab-content');

    tabBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Remove active classes from all buttons
            tabBtns.forEach(b => {
                b.classList.remove('active', 'border-secondary', 'text-secondary', 'bg-white', 'shadow-sm', 'text-slate-800', 'font-bold');
                b.classList.add('border-transparent', 'text-gray-500', 'text-slate-500', 'font-semibold', 'hover:bg-slate-50/50');
            });
            // Add active class to clicked button
            btn.classList.add('active', 'bg-white', 'shadow-sm', 'text-secondary', 'font-bold');
            btn.classList.remove('border-transparent', 'text-gray-500', 'text-slate-500', 'font-semibold', 'hover:bg-slate-50/50');

            // Hide all contents
            tabContents.forEach(c => {
                c.classList.add('hidden');
                c.classList.remove('block');
            });

            // Show target content
            const target = document.getElementById(btn.dataset.target);
            if (target) {
                target.classList.remove('hidden');
                target.classList.add('block');
            }
        });
    });
});

async function autoTranslateTitle() {
    const titleEn = document.getElementById('title_en').value;
    if (!titleEn) {
        showToast('Please enter an English title to translate.', 'warning');
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
        showToast('Title translation failed. Please try again or enter manually.', 'error');
        console.error(err);
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}

async function autoTranslateBody() {
    const contentEn = quillEn.getText().trim();
    if (!contentEn) {
        showToast('Please enter English content to translate.', 'warning');
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
        showToast('Body translation failed. Please try again or enter manually.', 'error');
        console.error(err);
    } finally {
        translateBtn.innerHTML = originalText;
        translateBtn.disabled = false;
    }
}
</script>

<?php include 'includes/footer.php'; ?>

