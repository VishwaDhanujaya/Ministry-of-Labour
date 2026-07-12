<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
requireLogin();

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    // Fetch and unlink files
    $stmt = $pdo->prepare("SELECT cover_image FROM news WHERE id = ?");
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
    
    $stmt = $pdo->prepare("DELETE FROM news WHERE id = ?");
    $stmt->execute([$del_id]);
    header("Location: news?success=deleted");
    exit;
}

// Handle Approve
if (isset($_GET['approve'])) {
    requireCsrfToken('GET', 'get');
    if (!hasPermission('approve_news')) {
        header("Location: index.php?error=forbidden");
        exit;
    }
    $app_id = (int)$_GET['approve'];
    $stmt = $pdo->prepare("UPDATE news SET status = 'Published' WHERE id = ?");
    $stmt->execute([$app_id]);
    header("Location: news?success=approved");
    exit;
}

// Active tab
$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'all';
$canApprove = hasPermission('approve_news');

// Count pending approvals
$pendingCountStmt = $pdo->query("SELECT COUNT(*) FROM news WHERE status = 'Pending Approval'");
$pendingCount = $pendingCountStmt->fetchColumn();

// Fetch Articles
$whereClause = "";
if ($activeTab === 'approvals' && $canApprove) {
    $whereClause = "WHERE n.status = 'Pending Approval'";
}
$stmt = $pdo->query("SELECT n.*, a.name as author_name FROM news n LEFT JOIN admins a ON n.author_id = a.id $whereClause ORDER BY n.created_at DESC");
$newsList = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">News</h2>
            <a href="news-add" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> Add News
            </a>
        </div>

        <?php if ($canApprove): ?>
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <a href="news?tab=all" class="<?= $activeTab === 'all' ? 'border-[#4E0000] text-[#4E0000]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-[13px] transition-colors">
                    All News
                </a>
                <a href="news?tab=approvals" class="<?= $activeTab === 'approvals' ? 'border-[#4E0000] text-[#4E0000]' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-[13px] transition-colors flex items-center">
                    Review & Approvals
                    <?php if ($pendingCount > 0): ?>
                        <span class="ml-2 bg-amber-100 text-amber-800 py-0.5 px-2.5 rounded-full text-[11px] font-bold inline-block">
                            <?= $pendingCount ?>
                        </span>
                    <?php endif; ?>
                </a>
            </nav>
        </div>
        <?php endif; ?>

        <!-- Table with integrated filter bar -->
        <?php
        $headers = [
            ['label' => 'Image', 'class' => 'w-16'],
            ['label' => 'Title', 'class' => ''],
            ['label' => 'Author', 'class' => ''],
            ['label' => 'Date', 'class' => ''],
            ['label' => 'Status & Visibility', 'class' => ''],
            ['label' => 'Actions', 'class' => '']
        ];
        
        renderAdminTable($headers, $newsList, function($news) {
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group cursor-pointer <?= $news['status'] === 'Pending Approval' ? 'bg-amber-50/40 relative' : '' ?>" onclick="showPreviewModal(<?= $news['id'] ?>, '<?= htmlspecialchars(addslashes($news['title'])) ?>', 'news-add?id=<?= $news['id'] ?>', 'news?delete=<?= $news['id'] ?>&csrf_token=<?= generateCsrfToken() ?>', <?= ($news['status'] === 'Pending Approval' && hasPermission('approve_news')) ? "'news?approve={$news['id']}&csrf_token=" . generateCsrfToken() . "'" : "null" ?>)">
                <?php if ($news['status'] === 'Pending Approval'): ?>
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-amber-400"></div>
                <?php endif; ?>
                <td class="py-5 px-6">
                    <?php if(!empty($news['cover_image']) && file_exists($news['cover_image'])): ?>
                        <a data-fslightbox="gallery" href="<?= htmlspecialchars($news['cover_image']) ?>" class="block rounded border border-gray-200 shadow-sm overflow-hidden w-12 h-12 cursor-pointer group" onclick="event.stopPropagation();">
                            <img loading="lazy" src="<?= htmlspecialchars($news['cover_image']) ?>" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                        </a>
                    <?php else: ?>
                        <div class="w-12 h-12 rounded bg-slate-100 border border-slate-200/70 flex items-center justify-center">
                            <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3.75 21h16.5a1.5 1.5 0 001.5-1.5V4.5a1.5 1.5 0 00-1.5-1.5H3.75a1.5 1.5 0 00-1.5 1.5v15a1.5 1.5 0 001.5 1.5z" /></svg>
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
                </td>
                <td class="py-5 px-6 text-gray-800"><?= htmlspecialchars($news['author_name'] ?? 'Unknown') ?></td>
                <td class="py-5 px-6 text-gray-800"><?= date('M d, Y', strtotime($news['created_at'])) ?></td>
                <td class="py-5 px-6">
                    <div class="flex flex-wrap items-center gap-1.5">
                        <?php if ($news['status'] === 'Published'): ?>
                        <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                        <?php elseif ($news['status'] === 'Pending Approval'): ?>
                        <span class="px-2.5 py-1 rounded-md bg-yellow-50 text-yellow-700 border border-yellow-200 text-[11px] font-bold shadow-sm">Pending Approval</span>
                        <?php else: ?>
                        <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                        <?php endif; ?>
                        
                        <span class="px-2.5 py-1 rounded-md <?= strtolower($news['visibility']) === 'public' ? 'bg-blue-50 text-blue-700 border border-blue-200' : 'bg-gray-50 text-gray-700 border border-gray-200' ?> text-[11px] font-bold shadow-sm">
                            <?= htmlspecialchars(ucfirst($news['visibility'] ?? 'Public')) ?>
                        </span>
                    </div>
                </td>
                <td class="py-5 px-6">
                    <div class="flex items-center space-x-2">
                        <a href="news-add?id=<?= $news['id'] ?>" onclick="event.stopPropagation();" class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        </a>
                        <a href="news?delete=<?= $news['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="event.stopPropagation();" data-confirm="Are you sure you want to delete this news item?" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'emptyTitle' => 'No news found',
            'emptySubtitle' => 'There are no news items matching your criteria.',
            'emptyIcon' => 'news',
            'filters' => [
                'search' => ['placeholder' => 'Search news...', 'maxWidth' => '50%'],
                'filters' => [
                    [
                        'icon' => 'status',
                        'placeholder' => 'All Status',
                        'options' => ['Published' => 'Published', 'Pending Approval' => 'Pending Approval', 'Draft' => 'Draft']
                    ]
                ],
                'reset' => true
            ],
            'pagination' => [
                'total_items' => count($newsList),
                'showing_count' => count($newsList),
                'per_page' => 10,
                'enable_paging' => true
            ]
        ]);
        ?>
    </main>

    <?php if (isset($_GET['success'])): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof window.showToast === 'function') {
                <?php if ($_GET['success'] == 'approved'): ?>
                window.showToast("Article approved and published successfully.", "success");
                <?php elseif ($_GET['success'] == 'deleted'): ?>
                window.showToast("Article deleted successfully.", "success");
                <?php endif; ?>
            }
        });
    </script>
    <?php endif; ?>

</div>


<!-- Preview Modal -->
<div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm" onclick="hidePreviewModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-0 transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden">
        <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50">
            <h3 id="preview-title" class="text-lg font-bold font-montserrat text-gray-900 truncate pr-4"></h3>
            <button onclick="hidePreviewModal()" class="text-gray-400 hover:text-gray-600 transition-colors focus:outline-none p-1 rounded-md hover:bg-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div id="preview-content-container" class="text-[14px] text-gray-700 overflow-y-auto p-6 md:p-8 flex-1 prose max-w-none"></div>
        <div class="flex justify-between items-center p-5 border-t border-gray-100 bg-gray-50 shrink-0">
            <span class="text-xs text-gray-500 font-medium">Quick Preview</span>
            <div class="flex gap-3">
                <a id="preview-approve-btn" href="#" class="hidden px-5 py-2 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white rounded-md text-[13px] font-bold hover:shadow-lg transition-all shadow-sm items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Approve & Publish
                </a>
                <a id="preview-edit-btn" href="#" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors shadow-sm">Edit News</a>
                <a id="preview-delete-btn" href="#" data-confirm="Are you sure you want to delete this?" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors shadow-sm">Delete</a>
            </div>
        </div>
    </div>
</div>
<script>
function showPreviewModal(id, title, editUrl, deleteUrl, approveUrl = null) {
    document.getElementById('preview-title').textContent = title;
    document.getElementById('preview-content-container').innerHTML = document.getElementById('preview-content-' + id).innerHTML;
    document.getElementById('preview-edit-btn').href = editUrl;
    document.getElementById('preview-delete-btn').href = deleteUrl;
    
    const approveBtn = document.getElementById('preview-approve-btn');
    if (approveUrl) {
        approveBtn.href = approveUrl;
        approveBtn.classList.remove('hidden');
        approveBtn.classList.add('inline-flex');
    } else {
        approveBtn.classList.add('hidden');
        approveBtn.classList.remove('inline-flex');
    }
    
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
