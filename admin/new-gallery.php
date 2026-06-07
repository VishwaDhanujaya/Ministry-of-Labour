<?php
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$error = '';
$success = '';
$gallery = null;
$gallery_images = [];

// Handle Delete Image
if (isset($_GET['delete_image']) && isset($_GET['id'])) {
    requireCsrfToken('GET', 'get');
    $img_id = (int)$_GET['delete_image'];
    $gallery_id = (int)$_GET['id'];
    
    $stmt = $pdo->prepare("SELECT image_path FROM gallery_images WHERE id = ? AND gallery_id = ?");
    $stmt->execute([$img_id, $gallery_id]);
    $img = $stmt->fetch();
    
    if ($img) {
        if (file_exists($img['image_path'])) {
            unlink($img['image_path']);
        }
        $pdo->prepare("DELETE FROM gallery_images WHERE id = ?")->execute([$img_id]);
        header("Location: new-gallery.php?id=" . $gallery_id . "&success=image_deleted");
        exit;
    }
}

// Check if editing
if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $stmt = $pdo->prepare("SELECT * FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $gallery = $stmt->fetch();
    
    if ($gallery) {
        $imgStmt = $pdo->prepare("SELECT * FROM gallery_images WHERE gallery_id = ?");
        $imgStmt->execute([$id]);
        $gallery_images = $imgStmt->fetchAll();
    }
}

if (isset($_GET['success']) && $_GET['success'] == 'image_deleted') {
    $success = "Image deleted successfully.";
}

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    requireCsrfToken('POST', 'post');
    $title = trim($_POST['title']);
    $status = $_POST['status'] ?? 'Public';
    
    if (empty($title)) {
        $error = "Title is required.";
    }

    $cover_image = $gallery ? $gallery['cover_image'] : null;
    
    if (empty($error)) {
        // Handle Cover Image Upload
        if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
            $uploadResult = handleFileUpload($_FILES['cover_image'], 'uploads/gallery');
            if ($uploadResult['success']) {
                if ($gallery && !empty($gallery['cover_image']) && file_exists($gallery['cover_image'])) {
                    unlink($gallery['cover_image']);
                }
                $cover_image = $uploadResult['path'];
            } else {
                $error = "Cover Image: " . $uploadResult['error'];
            }
        } elseif (!$gallery && empty($error)) {
            $error = "A cover image is required for a new album.";
        }
    }

    if (empty($error)) {
        if ($gallery) {
            $stmt = $pdo->prepare("UPDATE gallery SET title=?, cover_image=?, status=? WHERE id=?");
            $success_db = $stmt->execute([$title, $cover_image, $status, $gallery['id']]);
            $gallery_id = $gallery['id'];
        } else {
            $stmt = $pdo->prepare("INSERT INTO gallery (title, cover_image, status) VALUES (?, ?, ?)");
            $success_db = $stmt->execute([$title, $cover_image, $status]);
            $gallery_id = $pdo->lastInsertId();
        }

        if ($success_db) {
            $success = "Album saved successfully.";
            
            // Handle Multiple Images Upload
            if (isset($_FILES['gallery_images'])) {
                $files = $_FILES['gallery_images'];
                for ($i = 0; $i < count($files['name']); $i++) {
                    if ($files['error'][$i] === UPLOAD_ERR_OK) {
                        $singleFile = [
                            'name' => $files['name'][$i],
                            'type' => $files['type'][$i],
                            'tmp_name' => $files['tmp_name'][$i],
                            'error' => $files['error'][$i],
                            'size' => $files['size'][$i]
                        ];
                        
                        $uploadResult = handleFileUpload($singleFile, 'uploads/gallery');
                        if ($uploadResult['success']) {
                            $img_path = $uploadResult['path'];
                            $imgStmt = $pdo->prepare("INSERT INTO gallery_images (gallery_id, image_path) VALUES (?, ?)");
                            $imgStmt->execute([$gallery_id, $img_path]);
                        }
                    }
                }
            }

            header("Location: gallery.php");
            exit;
        } else {
            $error = "Failed to save the album.";
        }
    }
}

// Fetch recent albums for widget
$recentAlbums = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC LIMIT 5")->fetchAll();

$pageTitle = $gallery ? 'Edit Album' : 'New Album';
include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-8">
            <a href="gallery.php" class="p-2 rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            </a>
            <h2 class="text-3xl font-bold font-montserrat text-gray-900"><?= $pageTitle ?></h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Form -->
            <div class="lg:col-span-2 space-y-6">
                
                <?php if (!empty($error)): ?>
                    <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($success)): ?>
                    <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm font-medium">
                        <?= htmlspecialchars($success) ?>
                    </div>
                <?php endif; ?>

                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <form action="" method="POST" enctype="multipart/form-data" class="js-validate-form">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <div class="p-8 space-y-8">
                            
                            <!-- Title -->
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Album Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required value="<?= $gallery ? htmlspecialchars($gallery['title']) : '' ?>" placeholder="e.g., Annual Workshop 2026" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                            </div>

                            <!-- Visibility -->
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Visibility Status <span class="text-red-500">*</span></label>
                                <div class="relative">
                                    <select name="status" required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                        <option value="Public" <?= ($gallery && $gallery['status'] === 'Public') ? 'selected' : '' ?>>Public</option>
                                        <option value="Private" <?= ($gallery && $gallery['status'] === 'Private') ? 'selected' : '' ?>>Private</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>

                            <!-- Cover Image -->
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Cover Image <?= !$gallery ? '<span class="text-red-500">*</span>' : '' ?></label>
                                <div class="relative group cursor-pointer" onclick="document.getElementById('cover_input').click()">
                                    <div class="w-full border-2 border-dashed border-gray-200 rounded-lg p-8 flex flex-col items-center justify-center bg-[#F9FAFB] hover:bg-gray-50 hover:border-[#4E0000] transition-colors">
                                        <svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="text-[13px] font-semibold text-gray-700">Click to upload cover image</p>
                                        <p class="text-[11px] text-gray-500 mt-1">PNG, JPG, WEBP up to 5MB</p>
                                    </div>
                                    <input type="file" id="cover_input" name="cover_image" accept="image/*" class="sr-only" onchange="previewSingleImage(this, 'cover_preview')">
                                </div>
                                <div id="cover_preview" class="mt-4">
                                    <?php if($gallery && !empty($gallery['cover_image']) && file_exists($gallery['cover_image'])): ?>
                                        <div class="relative group inline-block">
                                            <img loading="lazy" src="<?= htmlspecialchars($gallery['cover_image']) ?>" class="h-32 object-cover rounded-lg border border-gray-200 shadow-sm">
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Additional Images -->
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Gallery Images</label>
                                <div class="relative group cursor-pointer" onclick="document.getElementById('gallery_input').click()">
                                    <div class="w-full border-2 border-dashed border-gray-200 rounded-lg p-8 flex flex-col items-center justify-center bg-[#F9FAFB] hover:bg-gray-50 hover:border-[#4E0000] transition-colors">
                                        <svg class="w-8 h-8 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                        <p class="text-[13px] font-semibold text-gray-700">Add multiple images to the album</p>
                                    </div>
                                    <input type="file" id="gallery_input" name="gallery_images[]" accept="image/*" multiple class="sr-only" onchange="previewMultipleImages(this, 'gallery_preview')">
                                </div>
                                
                                <div id="gallery_preview" class="mt-4 flex flex-wrap gap-3"></div>

                                <?php if (!empty($gallery_images)): ?>
                                <div class="mt-6">
                                    <h4 class="text-[12px] font-bold text-gray-800 mb-3 uppercase tracking-wider">Current Images</h4>
                                    <div class="flex flex-wrap gap-3">
                                        <?php foreach ($gallery_images as $img): ?>
                                            <div class="relative group">
                                                <img loading="lazy" src="<?= htmlspecialchars($img['image_path']) ?>" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm">
                                                <a href="new-gallery.php?id=<?= $gallery['id'] ?>&delete_image=<?= $img['id'] ?>" onclick="return confirm('Delete this image?')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                </a>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>

                        </div>
                        
                        <div class="bg-gray-50 p-6 border-t border-gray-100 flex justify-end gap-4">
                            <button type="submit" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                                Save Album
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden sticky top-8">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Recent Albums</h3>
                    </div>
                    <div class="p-6">
                        <?php if(empty($recentAlbums)): ?>
                            <p class="text-[13px] text-gray-500">No recent albums.</p>
                        <?php else: ?>
                            <?php foreach($recentAlbums as $album): ?>
                            <a href="new-gallery.php?id=<?= $album['id'] ?>" class="flex flex-col gap-1.5 cursor-pointer group mb-4 border-b border-gray-50 pb-4 last:border-0 last:pb-0">
                                <h4 class="font-semibold text-gray-900 text-[13px] group-hover:text-[#4E0000] transition-colors leading-snug"><?= htmlspecialchars($album['title']) ?></h4>
                                <div class="mt-1 flex items-center gap-2">
                                    <?php if ($album['status'] === 'Public'): ?>
                                    <span class="px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-[10px] font-bold">Public</span>
                                    <?php else: ?>
                                    <span class="px-2 py-0.5 rounded bg-gray-200 text-gray-800 text-[10px] font-bold">Private</span>
                                    <?php endif; ?>
                                    <span class="text-[11px] text-gray-500"><?= date('M j, Y', strtotime($album['created_at'])) ?></span>
                                </div>
                            </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>

<script>
function previewSingleImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.innerHTML = `<div class="relative group inline-block"><img loading="lazy" src="${e.target.result}" class="h-32 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-xs font-bold px-2 text-center">New Cover</span></div></div>`;
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function previewMultipleImages(input, previewId) {
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
</script>

<?php include 'includes/footer.php'; ?>
