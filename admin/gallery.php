<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle Delete
if (isset($_GET['delete'])) {
    $del_id = (int)$_GET['delete'];
    
    // First fetch cover and additional images to delete files
    $stmt = $pdo->prepare("SELECT cover_image FROM gallery WHERE id = ?");
    $stmt->execute([$del_id]);
    $gallery = $stmt->fetch();
    
    if ($gallery) {
        if (!empty($gallery['cover_image']) && file_exists($gallery['cover_image'])) {
            unlink($gallery['cover_image']);
        }
        
        $imgStmt = $pdo->prepare("SELECT image_path FROM gallery_images WHERE gallery_id = ?");
        $imgStmt->execute([$del_id]);
        while ($img = $imgStmt->fetch()) {
            if (file_exists($img['image_path'])) {
                unlink($img['image_path']);
            }
        }
        
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$del_id]);
        header("Location: gallery.php");
        exit;
    }
}

// Fetch Galleries with image counts
$stmt = $pdo->query("
    SELECT g.*, COUNT(gi.id) as image_count 
    FROM gallery g 
    LEFT JOIN gallery_images gi ON g.id = gi.gallery_id 
    GROUP BY g.id 
    ORDER BY g.created_at DESC
");
$galleries = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Gallery Albums</h2>
            <a href="new-gallery.php" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Album
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="flex flex-col md:flex-row gap-4 mb-6">
            <div class="relative flex-1 max-w-2xl">
                <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <input type="text" placeholder="Search by album title..." class="js-table-search w-full pl-10 pr-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] text-gray-800 placeholder-gray-400">
            </div>
            
            <div class="flex gap-4">
                <div class="relative w-36">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Status</option>
                        <option value="Public">Public</option>
                        <option value="Private">Private</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden overflow-x-auto">
            <table class="js-filterable-table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#13273F] text-white">
                        <th class="py-4 px-6 font-medium text-[15px] w-16">Cover</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Images</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Visibility</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[13px]">
                    <?php if (empty($galleries)): ?>
                    <tr>
                        <td colspan="6" class="py-16 px-6">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <p class="text-[14px] font-semibold text-gray-900 mb-1">No albums found</p>
                                <p class="text-[13px] text-gray-500">There are no gallery albums matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($galleries as $gallery): ?>
                    <tr class="hover:bg-gray-50 transition-colors group">
                        <td class="py-4 px-6">
                            <?php if(!empty($gallery['cover_image']) && file_exists($gallery['cover_image'])): ?>
                                <img src="<?= htmlspecialchars($gallery['cover_image']) ?>" class="w-12 h-12 rounded object-cover border border-gray-200 shadow-sm">
                            <?php else: ?>
                                <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-900 w-1/3"><?= htmlspecialchars($gallery['title']) ?></td>
                        <td class="py-4 px-6 text-gray-800">
                            <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 text-xs font-semibold"><?= $gallery['image_count'] ?> images</span>
                        </td>
                        <td class="py-4 px-6 text-gray-800"><?= date('M j, Y', strtotime($gallery['created_at'])) ?></td>
                        <td class="py-4 px-6">
                            <?php if ($gallery['status'] === 'Public'): ?>
                            <span class="px-3 py-1 rounded bg-[#EFF3F8] text-[#294B73] text-[11px] font-bold">Public</span>
                            <?php else: ?>
                            <span class="px-3 py-1 rounded bg-[#F4F4F5] text-[#45454E] text-[11px] font-bold">Private</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                <a href="new-gallery.php?id=<?= $gallery['id'] ?>" class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <a href="gallery.php?delete=<?= $gallery['id'] ?>" onclick="return confirm('Are you sure you want to delete this album and all its images?');" class="js-delete-row p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

<?php include 'includes/footer.php'; ?>
