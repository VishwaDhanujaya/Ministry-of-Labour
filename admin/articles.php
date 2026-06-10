<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    // Fetch and unlink files
    $stmt = $pdo->prepare("SELECT cover_image FROM articles WHERE id = ?");
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
    
    $stmt = $pdo->prepare("DELETE FROM articles WHERE id = ?");
    $stmt->execute([$del_id]);
    header("Location: articles");
    exit;
}

// Fetch Articles
$stmt = $pdo->query("SELECT n.*, a.name as author_name FROM articles n LEFT JOIN admins a ON n.author_id = a.id ORDER BY n.created_at DESC");
$newsList = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Articles</h2>
            <a href="new-article" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Article
            </a>
        </div>

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search by article..." class="js-table-search bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 pr-4 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400">
                </div>
            
            <div class="grid grid-cols-2 sm:flex sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-40">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Categories</option>
                        <option value="Media">Media</option>
                        <option value="Notices">Notices</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
                
                <div class="relative w-full sm:w-36">
                    <svg class="w-3.5 h-3.5 absolute left-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                    <select class="js-table-filter w-full pl-9 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Status</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter col-span-2 sm:col-span-1 px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center justify-center hover:bg-red-50 transition-colors">
                    <svg class="w-3.5 h-3.5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Reset Filter
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden overflow-x-auto">
            <table class="js-filterable-table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#13273F] text-white">
                        <th class="py-4 px-6 font-medium text-[15px] w-16">Image</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Title</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Category</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Author</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Date</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Status & Visibility</th>
                        <th class="py-4 px-6 font-medium text-[15px]">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-[13px]">
                    <?php if (empty($newsList)): ?>
                    <tr>
                        <td colspan="7" class="py-16 px-6">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9.5a2.5 2.5 0 00-2.5-2.5H15M9 11h2"></path></svg>
                                </div>
                                <p class="text-[14px] font-semibold text-gray-900 mb-1">No articles found</p>
                                <p class="text-[13px] text-gray-500">There are no articles matching your criteria.</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($newsList as $news): ?>
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer" onclick="showPreviewModal(<?= $news['id'] ?>, '<?= htmlspecialchars(addslashes($news['title'])) ?>', 'new-article?id=<?= $news['id'] ?>', 'articles?delete=<?= $news['id'] ?>&csrf_token=<?= generateCsrfToken() ?>')">
                        <td class="py-5 px-6">
                            <?php if(!empty($news['cover_image']) && file_exists($news['cover_image'])): ?>
                                <a data-fslightbox="gallery" href="<?= htmlspecialchars($news['cover_image']) ?>" class="block rounded border border-gray-200 shadow-sm overflow-hidden w-12 h-12 cursor-pointer group" onclick="event.stopPropagation();">
                                    <img loading="lazy" src="<?= htmlspecialchars($news['cover_image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                </a>
                            <?php else: ?>
                                <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center border border-gray-200">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                            <?php endif; ?>
                        </td>
                        <td class="py-5 px-6 font-medium text-gray-900 w-1/4">
                            <span class="text-left hover:text-[#4E0000] transition-colors focus:outline-none">
                                <?= htmlspecialchars($news['title']) ?>
                            </span>
                            <div id="preview-content-<?= $news['id'] ?>" class="hidden">
                                <div class="flex flex-col md:flex-row gap-6">
                                    <?php if(!empty($news['cover_image']) && file_exists($news['cover_image'])): ?>
                                        <div class="w-full md:w-[40%] shrink-0">
                                            <img src="<?= htmlspecialchars($news['cover_image']) ?>" class="w-full aspect-[4/3] object-cover rounded-xl shadow-sm border border-gray-100">
                                        </div>
                                    <?php else: ?>
                                        <div class="w-full md:w-[40%] shrink-0 bg-gray-100 rounded-xl flex items-center justify-center border border-gray-200 aspect-[4/3]">
                                            <span class="text-gray-400 text-sm">No Cover Image</span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="flex-1 flex flex-col">
                                        <div class="flex flex-wrap gap-2 mb-3">
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded uppercase tracking-wider"><?= htmlspecialchars($news['category']) ?></span>
                                            <span class="px-2 py-1 <?= $news['status'] === 'Published' ? 'bg-[#EDF7F4] text-[#166952]' : 'bg-[#FCF1F2] text-[#9E212D]' ?> text-[11px] font-bold rounded uppercase tracking-wider"><?= htmlspecialchars($news['status']) ?></span>
                                            <span class="px-2 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded uppercase tracking-wider"><?= date('M d, Y', strtotime($news['created_at'])) ?></span>
                                        </div>
                                        
                                        <div class="text-[13px] text-gray-600 line-clamp-6 leading-relaxed mb-4">
                                            <?= nl2br(htmlspecialchars(strip_tags($news['content'] ?? ''))) ?>
                                        </div>
                                        
                                        <div class="mt-auto pt-4 border-t border-gray-100 flex items-center justify-between text-[12px] text-gray-500 font-medium">
                                            <span>By <?= htmlspecialchars($news['author_name'] ?? 'Unknown') ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php if ($news['is_featured']): ?>
                                <div class="mt-1.5"><span class="px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 text-[10px] font-bold uppercase tracking-wider">Featured Notice</span></div>
                            <?php endif; ?>
                        </td>
                        <td class="py-5 px-6 text-gray-800"><?= htmlspecialchars($news['category']) ?></td>
                        <td class="py-5 px-6 text-gray-800"><?= htmlspecialchars($news['author_name'] ?? 'Unknown') ?></td>
                        <td class="py-5 px-6 text-gray-800"><?= date('M d, Y', strtotime($news['created_at'])) ?></td>
                        <td class="py-5 px-6">
                            <div class="flex flex-col gap-1.5 items-start">
                                <?php if ($news['status'] === 'Published'): ?>
                                <span class="px-3 py-1 rounded bg-[#EDF7F4] text-[#166952] text-[11px] font-bold">Published</span>
                                <?php else: ?>
                                <span class="px-3 py-1 rounded bg-[#FCF1F2] text-[#9E212D] text-[11px] font-bold">Draft</span>
                                <?php endif; ?>
                                
                                <span class="px-3 py-1 rounded <?= strtolower($news['visibility']) === 'public' ? 'bg-[#EFF3F8] text-[#294B73]' : 'bg-[#F4F4F5] text-[#45454E]' ?> text-[11px] font-bold">
                                    <?= htmlspecialchars(ucfirst($news['visibility'] ?? 'Public')) ?>
                                </span>
                            </div>
                        </td>
                        <td class="py-5 px-6">
                            <div class="flex items-center space-x-2">
                                <a href="new-article?id=<?= $news['id'] ?>" onclick="event.stopPropagation();" class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </a>
                                <a href="articles?delete=<?= $news['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="event.stopPropagation(); return confirm('Are you sure you want to delete this article?');" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
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
<div id="preview-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0" style="z-index: 9999;">
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
            <a id="preview-delete-btn" href="#" onclick="return confirm('Are you sure you want to delete this?');" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors">Delete</a>
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

