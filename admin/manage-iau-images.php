<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_iau');

$update_id = isset($_GET['update_id']) ? (int)$_GET['update_id'] : 0;
if (!$update_id) {
    header('Location: manage-iau-updates');
    exit;
}

// Fetch album details
$stmt = $pdo->prepare("SELECT * FROM iau_updates WHERE id = ?");
$stmt->execute([$update_id]);
$album = $stmt->fetch();
if (!$album) {
    header('Location: manage-iau-updates');
    exit;
}

$current_page = "manage-iau-updates"; // Keep sidebar active on the gallery page
$error = '';
$success = '';

// Handle Delete Image
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT image_path FROM iau_update_images WHERE id = ? AND update_id = ?");
    $stmt->execute([$del_id, $update_id]);
    $img = $stmt->fetch();
    
    if ($img) {
        if (!empty($img['image_path']) && file_exists('../' . $img['image_path'])) {
            @unlink('../' . $img['image_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM iau_update_images WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Image deleted successfully.";
    } else {
        $error = "Image not found.";
    }
}

// Handle Add Images
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_images') {
    requireCsrfToken('POST', 'post');
    
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $uploaded_count = 0;
        $file_count = count($_FILES['images']['name']);
        
        for ($i = 0; $i < $file_count; $i++) {
            if ($_FILES['images']['error'][$i] === UPLOAD_ERR_OK) {
                // Re-format array for handleFileUpload
                $file = [
                    'name' => $_FILES['images']['name'][$i],
                    'type' => $_FILES['images']['type'][$i],
                    'tmp_name' => $_FILES['images']['tmp_name'][$i],
                    'error' => $_FILES['images']['error'][$i],
                    'size' => $_FILES['images']['size'][$i]
                ];
                
                $uploadResult = handleFileUpload($file, 'uploads/iau', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                if ($uploadResult['success']) {
                    $image_path = $uploadResult['path'];
                    
                    $stmt = $pdo->prepare("INSERT INTO iau_update_images (update_id, image_path, sort_order) VALUES (?, ?, ?)");
                    $stmt->execute([$update_id, $image_path, 0]);
                    $uploaded_count++;
                } else {
                    $error .= "Failed to upload " . htmlspecialchars($file['name']) . ": " . $uploadResult['error'] . "<br>";
                }
            }
        }
        
        if ($uploaded_count > 0) {
            $success = "$uploaded_count images uploaded successfully.";
        }
    } else {
        $error = "Please select at least one image.";
    }
}

$stmt = $pdo->prepare("SELECT * FROM iau_update_images WHERE update_id = ? ORDER BY sort_order ASC, id DESC");
$stmt->execute([$update_id]);
$images = $stmt->fetchAll();

$pageTitle = 'Manage Images - ' . $album['title_en'];
include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 bg-[#F8F9FA]">
        <?php if (!empty($error)): ?>
            <script>document.addEventListener('DOMContentLoaded', () => { window.showToast('<?= addslashes($error) ?>', 'error'); });</script>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <script>document.addEventListener('DOMContentLoaded', () => { window.showToast('<?= addslashes($success) ?>', 'success'); });</script>
        <?php endif; ?>

        <div class="mb-4">
            <a href="manage-iau-updates" class="inline-flex items-center text-[13px] font-medium text-slate-500 hover:text-secondary transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Back to Albums
            </a>
        </div>

        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Images</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Album: <span class="font-bold text-slate-700"><?= htmlspecialchars($album['title_en']) ?></span></p>
            </div>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-100 mb-8">
            <h3 class="text-lg font-bold font-montserrat text-slate-800 mb-4">Upload New Images</h3>
            <form action="" method="POST" enctype="multipart/form-data" class="flex flex-col sm:flex-row items-end gap-4">
                <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                <input type="hidden" name="action" value="add_images">
                
                <div class="flex-1 w-full">
                    <label class="block text-[13px] font-medium text-gray-800 mb-2">Select Images (Multiple allowed)</label>
                    <input type="file" name="images[]" multiple accept="image/jpeg,image/png,image/webp" class="w-full text-sm border border-gray-200 rounded-lg p-2 bg-[#F9FAFB] focus:outline-none" required>
                </div>
                
                <button type="submit" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-6 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all whitespace-nowrap">
                    Upload Images
                </button>
            </form>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-6">
            <?php foreach ($images as $img): ?>
                <div class="relative group bg-white p-2 rounded-xl shadow-sm border border-slate-100">
                    <div class="aspect-square rounded-lg overflow-hidden relative">
                        <?php 
                        $imgSrc = '';
                        if (!empty($img['image_path'])) {
                            if (file_exists($img['image_path'])) {
                                $imgSrc = $img['image_path'];
                            } elseif (file_exists('uploads/iau/' . basename($img['image_path']))) {
                                $imgSrc = 'uploads/iau/' . basename($img['image_path']);
                            } elseif (file_exists('../' . $img['image_path'])) {
                                $imgSrc = '../' . $img['image_path'];
                            }
                        }
                        ?>
                        <img src="<?= htmlspecialchars($imgSrc) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-200 flex items-center justify-center">
                            <a href="manage-iau-images?update_id=<?= $update_id ?>&delete=<?= $img['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this image?" class="w-10 h-10 bg-white/20 hover:bg-rose-500 rounded-full flex items-center justify-center text-white backdrop-blur-sm transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <?php if (empty($images)): ?>
                <div class="col-span-full py-12 text-center text-slate-400 text-[13px]">
                    No images uploaded to this album yet.
                </div>
            <?php endif; ?>
        </div>

    </main>
    <?php include 'includes/footer.php'; ?>
</div>
