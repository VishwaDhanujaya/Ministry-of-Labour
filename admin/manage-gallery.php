<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_path FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();
    
    if ($item) {
        if (file_exists($item['image_path'])) {
            unlink($item['image_path']);
        }
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        $success = "Gallery item deleted successfully.";
    }
}

// Handle Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] == 'upload') {
    $title = trim($_POST['title']);
    $status = $_POST['status'] ?? 'Published';
    
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = handleFileUpload($_FILES['image'], 'uploads/gallery');
        if ($uploadResult['success']) {
            $image_path = 'uploads/gallery/' . $uploadResult['filename'];
            
            $stmt = $pdo->prepare("INSERT INTO gallery (title, image_path, status) VALUES (?, ?, ?)");
            if ($stmt->execute([$title, $image_path, $status])) {
                $success = "Image uploaded successfully.";
            } else {
                $error = "Failed to save to database.";
            }
        } else {
            $error = $uploadResult['error'];
        }
    } else {
        $error = "Please select a valid image.";
    }
}

// Fetch Gallery Items
$stmt = $pdo->query("SELECT * FROM gallery ORDER BY created_at DESC");
$galleryItems = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Manage Gallery</h2>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Column: Main Form (Col 1) -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden mb-8">
                    <div class="bg-[#13273F] text-white p-5">
                        <h3 class="font-medium text-[15px]">Upload New Image</h3>
                    </div>
                    <div class="p-6 space-y-6">
                        <?php if (!empty($error)): ?>
                            <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-600 text-sm font-medium mb-4">
                                <?= htmlspecialchars($error) ?>
                            </div>
                        <?php endif; ?>
                        <?php if (!empty($success)): ?>
                            <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-600 text-sm font-medium mb-4">
                                <?= htmlspecialchars($success) ?>
                            </div>
                        <?php endif; ?>

                        <form action="manage-gallery.php" method="POST" enctype="multipart/form-data" class="space-y-6">
                            <input type="hidden" name="action" value="upload">
                            
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Image Title/Caption <span class="text-red-500">*</span></label>
                                <input type="text" name="title" required placeholder="Enter caption" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900 placeholder-gray-400">
                            </div>
                            
                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Image <span class="text-red-500">*</span></label>
                                <input type="file" name="image" accept="image/png, image/jpeg, image/jpg, image/webp" required class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-900">
                            </div>

                            <div>
                                <label class="block text-[13px] font-semibold text-gray-800 mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-600 appearance-none cursor-pointer">
                                        <option value="Published">Published</option>
                                        <option value="Draft">Draft (Hidden)</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            
                            <button type="submit" class="w-full py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors">
                                Upload Image
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Right Column: Gallery List (Col 2) -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-[#13273F] text-white">
                                <th class="py-4 px-6 font-medium text-[15px]">Image</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Status</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                                <th class="py-4 px-6 font-medium text-[15px]">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-[13px]">
                            <?php if (empty($galleryItems)): ?>
                            <tr>
                                <td colspan="5" class="py-5 px-6 text-center text-gray-500">No gallery items found.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($galleryItems as $item): ?>
                            <tr class="hover:bg-gray-50 transition-colors group">
                                <td class="py-3 px-6">
                                    <div class="w-16 h-12 bg-gray-200 rounded overflow-hidden">
                                        <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="thumbnail" class="w-full h-full object-cover">
                                    </div>
                                </td>
                                <td class="py-5 px-6 font-medium text-gray-900"><?= htmlspecialchars($item['title']) ?></td>
                                <td class="py-5 px-6">
                                    <?php if ($item['status'] === 'Published'): ?>
                                    <span class="px-3 py-1 rounded bg-[#D1F1E8] text-[#0A6C5B] text-[11px] font-bold">Published</span>
                                    <?php else: ?>
                                    <span class="px-3 py-1 rounded bg-[#EED6D6] text-[#611A1A] text-[11px] font-bold">Draft</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-5 px-6 text-gray-800"><?= date('M j, Y', strtotime($item['created_at'])) ?></td>
                                <td class="py-5 px-6">
                                    <a href="manage-gallery.php?delete=<?= $item['id'] ?>" onclick="return confirm('Are you sure you want to delete this image?');" class="text-red-500 hover:text-red-700 font-bold transition-colors">Delete</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
