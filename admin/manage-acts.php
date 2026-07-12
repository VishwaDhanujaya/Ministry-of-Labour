<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$current_page = "manage-acts";
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT pdf_path FROM acts_amendments WHERE id = ?");
    $stmt->execute([$del_id]);
    $act = $stmt->fetch();
    
    if ($act) {
        if (!empty($act['pdf_path']) && file_exists($act['pdf_path'])) {
            unlink($act['pdf_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM acts_amendments WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Act/Amendment deleted successfully.";
    } else {
        $error = "Act/Amendment not found.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    $title = trim($_POST['title']);
    $ref = trim($_POST['ref']);
    $category = $_POST['category'] ?? 'Acts';
    $status = $_POST['status'];
    
    if (empty($title)) {
        $error = "Title is required.";
    } else {
        if ($action === 'add') {
            if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
                $error = "PDF file is required.";
            } else {
                $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/acts', ['application/pdf'], 5242880);
                if ($uploadResult['success']) {
                    $pdf_path = $uploadResult['path'];
                    $stmt = $pdo->prepare("INSERT INTO acts_amendments (title, ref, category, pdf_path, status) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt->execute([$title, $ref, $category, $pdf_path, $status])) {
                        $success = "Act/Amendment added successfully.";
                    } else {
                        $error = "Failed to add Act/Amendment.";
                    }
                } else {
                    $error = $uploadResult['error'];
                }
            }
        } elseif ($action === 'edit') {
            $edit_id = (int)$_POST['act_id'];
            
            $stmt = $pdo->prepare("SELECT pdf_path FROM acts_amendments WHERE id = ?");
            $stmt->execute([$edit_id]);
            $existing = $stmt->fetch();
            
            if (!$existing) {
                $error = "Act/Amendment not found.";
            } else {
                $pdf_path = $existing['pdf_path'];
                
                // If new file uploaded
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/acts', ['application/pdf'], 5242880);
                    if ($uploadResult['success']) {
                        if (!empty($pdf_path) && file_exists($pdf_path)) {
                            unlink($pdf_path);
                        }
                        $pdf_path = $uploadResult['path'];
                    } else {
                        $error = $uploadResult['error'];
                    }
                }
                
                if (empty($error)) {
                    $stmt = $pdo->prepare("UPDATE acts_amendments SET title = ?, ref = ?, category = ?, pdf_path = ?, status = ? WHERE id = ?");
                    if ($stmt->execute([$title, $ref, $category, $pdf_path, $status, $edit_id])) {
                        $success = "Act/Amendment updated successfully.";
                    } else {
                        $error = "Failed to update Act/Amendment.";
                    }
                }
            }
        }
    }
}

// Fetch Acts & Amendments
$stmt = $pdo->query("SELECT * FROM acts_amendments ORDER BY created_at DESC");
$acts = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Acts & Amendments</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Configure, edit, and publish statutory Labour Acts and legal Amendments.</p>
            </div>
            <button onclick="openAddModal()" class="bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Document
            </button>
        </div>

        <!-- Success & Error Alert Banners -->
        <?php if (!empty($success)): ?>
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-100 text-emerald-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span><?= htmlspecialchars($success) ?></span>
            </div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-100 text-rose-800 flex items-center gap-3 text-xs font-semibold shadow-sm animate-fadeIn">
                <svg class="w-5 h-5 text-rose-600 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"></path></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Filter Bar -->
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-[0_4px_16px_rgba(0,0,0,0.015)] mb-6 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[40%]">
                <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.637 10.637z"></path></svg>
                </span>
                <input type="text" placeholder="Search by title or reference..." class="js-table-search bg-slate-50 border border-slate-200/70 text-slate-700 text-[13px] rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] block w-full pl-10 pr-4 py-2.5 font-inter transition-all outline-none">
            </div>
            
            <div class="flex items-center gap-3 w-full md:w-auto">
                <div class="relative flex-1 md:w-44">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581a1.44 1.44 0 002.036 0l4.319-4.319a1.44 1.44 0 000-2.036L10.01 3.659A2.25 2.25 0 008.59 3z"></path></svg>
                    </span>
                    <select class="js-table-filter w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/70 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] font-semibold text-slate-700 appearance-none cursor-pointer hover:bg-slate-100/50 transition-all">
                        <option value="">All Categories</option>
                        <option value="Acts">Acts</option>
                        <option value="Amendments">Amendments</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                    </span>
                </div>
                <div class="relative flex-1 md:w-44">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" /></svg>
                    </span>
                    <select class="js-table-filter w-full pl-10 pr-10 py-2.5 bg-slate-50 border border-slate-200/70 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] font-semibold text-slate-700 appearance-none cursor-pointer hover:bg-slate-100/50 transition-all">
                        <option value="">All Statuses</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                    </span>
                </div>

                <button class="js-reset-filter px-5 py-2.5 bg-rose-50/50 border border-rose-100/50 rounded-xl text-[12.5px] font-bold text-rose-600 hover:bg-rose-50 hover:text-rose-700 transition-all shadow-sm">
                    Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <?php
        $headers = [
            ['label' => 'Title & Ref', 'class' => ''],
            ['label' => 'Category', 'class' => 'w-36'],
            ['label' => 'PDF', 'class' => 'w-36'],
            ['label' => 'Status', 'class' => 'w-36'],
            ['label' => 'Date Added', 'class' => 'w-36'],
            ['label' => 'Actions', 'class' => 'text-right w-32']
        ];
        
        renderAdminTable($headers, $acts, function($act) {
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group cursor-pointer" onclick="showPreviewModal(<?= $act['id'] ?>, '<?= htmlspecialchars(addslashes($act['title'])) ?>', 'manage-acts?delete=<?= $act['id'] ?>&csrf_token=<?= generateCsrfToken() ?>', <?= htmlspecialchars(json_encode($act, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)">
                <td class="py-4 px-6">
                    <p class="text-[13.5px] font-bold text-slate-800 group-hover:text-[#4E0000] transition-colors leading-none mb-1"><?= htmlspecialchars($act['title']) ?></p>
                    <?php if(!empty($act['ref'])): ?>
                        <p class="text-[11.5px] text-slate-400 mt-1.5 font-semibold"><?= htmlspecialchars($act['ref']) ?></p>
                    <?php endif; ?>
                    
                    <!-- Hidden Preview Content -->
                    <div id="preview-content-<?= $act['id'] ?>" class="hidden">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-wrap gap-2">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-sm"><?= htmlspecialchars($act['category']) ?></span>
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold border shadow-sm <?= $act['status'] === 'Published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-700 border-orange-200' ?>"><?= htmlspecialchars($act['status']) ?></span>
                                <span class="px-2.5 py-1 bg-gray-50 text-gray-600 border border-slate-100 text-[11px] font-bold rounded-md shadow-sm uppercase tracking-wider"><?= date('M d, Y', strtotime($act['created_at'])) ?></span>
                            </div>
                            <?php if (!empty($act['ref'])): ?>
                                <div class="text-[13px] text-gray-700 mt-2">
                                    <strong>Reference:</strong> <?= htmlspecialchars($act['ref']) ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($act['pdf_path'])): ?>
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <a href="<?= htmlspecialchars(resolvePdfUrl($act['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center px-4 py-2 bg-[#13273F] text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        View Attached PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-bold shadow-sm"><?= htmlspecialchars($act['category']) ?></span>
                </td>
                <td class="py-4 px-6">
                    <a href="<?= htmlspecialchars(resolvePdfUrl($act['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center text-[#4E0000] hover:text-[#721c1c] text-[13px] font-bold transition-colors">
                        <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        View PDF
                    </a>
                </td>
                <td class="py-4 px-6">
                    <?php if ($act['status'] === 'Published'): ?>
                    <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                    <?php else: ?>
                    <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-[13px] text-slate-400 font-mono"><?= date('M d, Y', strtotime($act['created_at'])) ?></td>
                <td class="py-4 px-6 text-right" onclick="event.stopPropagation();">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick='openEditModal(<?= json_encode($act, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                        </button>
                        <a href="manage-acts?delete=<?= $act['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this document?" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'minWidth' => '900px',
            'emptyTitle' => 'No Acts or Amendments found',
            'emptySubtitle' => 'There are no acts matching your criteria.',
            'pagination' => [
                'total_items' => count($acts),
                'showing_count' => count($acts)
            ]
        ]);
        ?>

        <!-- Add/Edit Modal -->
        <div id="actModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
            <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeActModal()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col border border-slate-100">
                <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 class="text-lg font-bold font-montserrat text-slate-800 flex items-center gap-2" id="modalTitle">
                        <!-- Filled by JS -->
                    </h3>
                    <button type="button" onclick="closeActModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <form id="actForm" action="" method="POST" enctype="multipart/form-data" class="js-validate-form space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="act_id" id="actId" value="">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="actTitle" required placeholder="Act/Amendment Title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 font-semibold">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Reference No.</label>
                                <input type="text" name="ref" id="actRef" placeholder="e.g. Act No. 19 of 1954" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-700 placeholder-slate-400 font-semibold">
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                                <div class="relative">
                                    <select name="category" id="actCategory" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-600 appearance-none cursor-pointer font-semibold">
                                        <option value="Acts">Acts</option>
                                        <option value="Amendments">Amendments</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" id="actStatus" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#13273F]/20 focus:border-[#13273F] text-[13px] text-slate-600 appearance-none cursor-pointer font-semibold">
                                        <option value="Published">Published</option>
                                        <option value="Draft">Draft</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" id="pdfLabel">PDF File <span class="text-red-500">*</span></label>
                            
                            <!-- Premium Custom File Input -->
                            <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-6 hover:border-[#13273F] transition-all bg-slate-50/50 flex flex-col items-center justify-center cursor-pointer group text-center" onclick="document.getElementById('actPdf').click()">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-[#13273F] transition-colors mb-2" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" /></svg>
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider block" id="pdfFileName">Select or drag PDF File</span>
                                <span class="text-[10px] text-slate-400 mt-1 block">Only PDF documents up to 5MB are accepted</span>
                                <input type="file" name="pdf_file" id="actPdf" accept="application/pdf" required class="hidden" onchange="showSelectedFileName(this)">
                            </div>
                            <p id="editPdfHint" class="text-[11px] text-slate-400 italic hidden mt-1.5">Leave blank if you wish to keep the currently uploaded PDF.</p>
                        </div>

                        <div class="pt-5 flex justify-end gap-3 border-t border-slate-100 mt-6 font-inter shrink-0">
                            <button type="button" onclick="closeActModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-gradient-to-r from-[#4E0000] to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">
                                Save Document
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function showSelectedFileName(input) {
            const fileNameDisplay = document.getElementById('pdfFileName');
            if (input.files && input.files.length > 0) {
                fileNameDisplay.textContent = input.files[0].name;
                fileNameDisplay.className = "text-xs text-emerald-600 font-bold uppercase tracking-wider block";
            } else {
                fileNameDisplay.textContent = "Select or drag PDF File";
                fileNameDisplay.className = "text-xs text-slate-500 font-bold uppercase tracking-wider block";
            }
        }

        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Add New Document';
            document.getElementById('formAction').value = 'add';
            document.getElementById('actId').value = '';
            
            document.getElementById('actTitle').value = '';
            document.getElementById('actRef').value = '';
            document.getElementById('actCategory').value = 'Acts';
            document.getElementById('actStatus').value = 'Published';
            document.getElementById('actPdf').value = '';
            
            document.getElementById('pdfFileName').textContent = "Select or drag PDF File";
            document.getElementById('pdfFileName').className = "text-xs text-slate-500 font-bold uppercase tracking-wider block";
            
            document.getElementById('actPdf').required = true;
            document.getElementById('pdfLabel').innerHTML = 'PDF File <span class="text-red-500">*</span>';
            document.getElementById('editPdfHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Document';
            
            const modal = document.getElementById('actModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function openEditModal(act) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-[#13273F]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg> Edit Document';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('actId').value = act.id;
            
            document.getElementById('actTitle').value = act.title;
            document.getElementById('actRef').value = act.ref || '';
            document.getElementById('actCategory').value = act.category || 'Acts';
            document.getElementById('actStatus').value = act.status;
            document.getElementById('actPdf').value = '';
            
            if (act.pdf_path) {
                const parts = act.pdf_path.split('/');
                document.getElementById('pdfFileName').textContent = parts[parts.length - 1];
                document.getElementById('pdfFileName').className = "text-xs text-slate-700 font-bold uppercase tracking-wider block";
            } else {
                document.getElementById('pdfFileName').textContent = "Select or drag PDF File";
                document.getElementById('pdfFileName').className = "text-xs text-slate-500 font-bold uppercase tracking-wider block";
            }
            
            document.getElementById('actPdf').required = false;
            document.getElementById('pdfLabel').textContent = 'PDF File (New)';
            document.getElementById('editPdfHint').classList.remove('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Save Changes';
            
            const modal = document.getElementById('actModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function closeActModal() {
            const modal = document.getElementById('actModal');
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

        <!-- Preview Modal -->
        <div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0">
            <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="hidePreviewModal()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl p-0 transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col overflow-hidden border border-slate-100">
                <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 id="preview-title" class="text-lg font-bold font-montserrat text-slate-800 truncate pr-4"></h3>
                    <button onclick="hidePreviewModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <div id="preview-content-container" class="text-[13.5px] text-slate-600 overflow-y-auto p-6 md:p-8 flex-1 prose max-w-none custom-scrollbar"></div>
                <div class="flex justify-between items-center p-5 border-t border-slate-100 bg-slate-50/30 shrink-0 font-inter">
                    <span class="text-xs text-slate-400 font-bold uppercase tracking-wider">Quick Preview</span>
                    <div class="flex gap-3">
                        <button id="preview-edit-btn" class="px-5 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors shadow-sm">Edit</button>
                        <a id="preview-delete-btn" href="#" data-confirm="Are you sure you want to delete this?" class="px-5 py-2 bg-gradient-to-r from-red-600 to-red-700 text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all flex items-center justify-center">Delete</a>
                    </div>
                </div>
            </div>
        </div>

        <script>
        let activePreviewData = null;
        function showPreviewModal(id, title, deleteUrl, itemData) {
            document.getElementById('preview-title').textContent = title;
            document.getElementById('preview-content-container').innerHTML = document.getElementById('preview-content-' + id).innerHTML;
            document.getElementById('preview-delete-btn').href = deleteUrl;
            activePreviewData = itemData;
            
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

        document.getElementById('preview-edit-btn').addEventListener('click', function() {
            if (activePreviewData) {
                hidePreviewModal();
                openEditModal(activePreviewData);
            }
        });
        </script>
    </main>
</div>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-8px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fadeIn {
    animation: fadeIn 0.25s ease-out forwards;
}
.custom-scrollbar::-webkit-scrollbar {
    height: 5px;
    width: 5px;
}
.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}
.custom-scrollbar::-webkit-scrollbar-thumb {
    background: #E2E8F0;
    border-radius: 9999px;
}
.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: #CBD5E1;
}
</style>

<?php include 'includes/footer.php'; ?>
