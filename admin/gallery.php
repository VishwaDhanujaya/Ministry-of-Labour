<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
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
        header("Location: gallery");
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
            <a href="new-gallery" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Album
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search by album title..." class="js-table-search bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 pr-4 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400">
                </div>
            
            <div class="flex gap-4 w-full sm:w-auto">
                <div class="relative w-full sm:w-36">
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
                    <tr class="hover:bg-gray-50 transition-colors group cursor-pointer" onclick="showPreviewModal(<?= $gallery['id'] ?>, '<?= htmlspecialchars(addslashes($gallery['title'])) ?>', 'new-gallery?id=<?= $gallery['id'] ?>', 'gallery?delete=<?= $gallery['id'] ?>&csrf_token=<?= generateCsrfToken() ?>')">
                        <td class="py-4 px-6">
                            <?php if(!empty($gallery['cover_image']) && file_exists($gallery['cover_image'])): ?>
                                <a data-fslightbox="gallery" href="<?= htmlspecialchars($gallery['cover_image']) ?>" class="block rounded border border-gray-200 shadow-sm overflow-hidden w-12 h-12 cursor-pointer group" onclick="event.stopPropagation();">
                                    <img loading="lazy" src="<?= htmlspecialchars($gallery['cover_image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </a>
                            <?php else: ?>
                                <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 font-medium text-gray-900 w-1/3">
                            <span class="text-left hover:text-[#4E0000] transition-colors focus:outline-none">
                                <?= htmlspecialchars($gallery['title']) ?>
                            </span>
                            <div id="preview-content-<?= $gallery['id'] ?>" class="hidden">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <?php if(!empty($gallery['cover_image']) && file_exists($gallery['cover_image'])): ?>
                                        <div class="w-full md:w-[40%] shrink-0">
                                            <img src="<?= htmlspecialchars($gallery['cover_image']) ?>" class="w-full aspect-[4/3] object-cover rounded-xl shadow-sm border border-gray-100">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-full md:w-[40%] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200 aspect-[4/3]">
                                            <span class="text-gray-400 text-sm">No Cover Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="px-2 py-1 <?= $gallery['status'] === 'Public' ? 'bg-[#EFF3F8] text-[#294B73]' : 'bg-[#F4F4F5] text-[#45454E]' ?> text-[11px] font-bold rounded uppercase tracking-wider"><?= htmlspecialchars($gallery['status']) ?></span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded uppercase tracking-wider"><?= $gallery['image_count'] ?> images</span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded uppercase tracking-wider"><?= date('M d, Y', strtotime($gallery['created_at'])) ?></span>
                                        </div>
                                        
                                        <p class="text-[13px] text-gray-600 leading-relaxed line-clamp-4 mb-4">
                                            This gallery album contains <strong><?= $gallery['image_count'] ?></strong> uploaded images.
                                        </p>
                                        
                                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-[12px] text-gray-500 font-medium">
                                            <span>Created on <?= date('M j, Y', strtotime($gallery['created_at'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
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
                            <div class="flex items-center space-x-2 opacity-100 md:opacity-0 md:group-hover:opacity-100 transition-opacity">
                                <a href="new-gallery?id=<?= $gallery['id'] ?>" onclick="event.stopPropagation();" class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <a href="gallery?delete=<?= $gallery['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this album and all its images?');" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
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

<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="hidePreviewModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl p-6 transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col">
        <div class="flex justify-between items-start mb-4">
            <h3 id="preview-title" class="text-xl font-bold font-montserrat text-gray-900"></h3>
            <button onclick="hidePreviewModal()" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div id="preview-content-container" class="text-[14px] text-gray-700 overflow-y-auto pr-2 mb-6 flex-1"></div>
        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100 shrink-0">
            <a id="preview-edit-btn" href="#" class="px-5 py-2 bg-gray-100 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-200 transition-colors">Edit</a>
            <a id="preview-delete-btn" href="#" onclick="return confirm('Are you sure you want to delete this album?');" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors">Delete</a>
        </div>
    </div>
</div>
<script>
function showPreviewModal(id, title, editUrl, deleteUrl) {
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-content-container').innerHTML = document.getElementById('preview-content-' + id).innerHTML;
    document.getElementById('preview-edit-btn').href = editUrl;
    document.getElementById('preview-delete-btn').href = deleteUrl;
    
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    void modal.offsetWidth; // trigger reflow
    modal.classList.remove('opacity-0');
    modalBox.classList.remove('scale-95');
    modalBox.classList.add('scale-100');
}

function hidePreviewModal() {
    const modal = document.getElementById('preview-modal');
    const modalBox = modal.querySelector('.bg-white');
    
    modal.classList.add('opacity-0');
    modalBox.classList.remove('scale-100');
    modalBox.classList.add('scale-95');
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }, 300);
}
</script>

<?php include 'includes/footer.php'; ?>


