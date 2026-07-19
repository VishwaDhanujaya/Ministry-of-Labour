<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_procurements');

$current_page = "manage-procurements";
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT pdf_path FROM procurements WHERE id = ?");
    $stmt->execute([$del_id]);
    $proc = $stmt->fetch();
    
    if ($proc) {
        if (!empty($proc['pdf_path']) && file_exists($proc['pdf_path'])) {
            unlink($proc['pdf_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM procurements WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Procurement deleted successfully.";
    } else {
        $error = "Procurement not found.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    $title = trim($_POST['title']);
    $category = $_POST['category'] ?? 'Notice';
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    
    if (empty($title)) {
        $error = "Title is required.";
    } else {
        if ($action === 'add') {
            if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
                $error = "PDF file is required.";
            } else {
                $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/procurements', ['application/pdf'], 5242880);
                if ($uploadResult['success']) {
                    $pdf_path = $uploadResult['path'];
                    $stmt = $pdo->prepare("INSERT INTO procurements (title, category, description, pdf_path, status) VALUES (?, ?, ?, ?, ?)");
                    if ($stmt->execute([$title, $category, $description, $pdf_path, $status])) {
                        $success = "Procurement added successfully.";
                    } else {
                        $error = "Failed to add procurement.";
                    }
                } else {
                    $error = $uploadResult['error'];
                }
            }
        } elseif ($action === 'edit') {
            $edit_id = (int)$_POST['proc_id'];
            
            $stmt = $pdo->prepare("SELECT pdf_path FROM procurements WHERE id = ?");
            $stmt->execute([$edit_id]);
            $existing = $stmt->fetch();
            
            if (!$existing) {
                $error = "Procurement not found.";
            } else {
                $pdf_path = $existing['pdf_path'];
                
                // If new file uploaded
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/procurements', ['application/pdf'], 5242880);
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
                    $stmt = $pdo->prepare("UPDATE procurements SET title = ?, category = ?, description = ?, pdf_path = ?, status = ? WHERE id = ?");
                    if ($stmt->execute([$title, $category, $description, $pdf_path, $status, $edit_id])) {
                        $success = "Procurement updated successfully.";
                    } else {
                        $error = "Failed to update procurement.";
                    }
                }
            }
        }
    }
}

// Fetch Procurements
$stmt = $pdo->query("SELECT * FROM procurements ORDER BY created_at DESC");
$procurements = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Procurements</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Configure, edit, and publish procurement tenders and contract plans.</p>
            </div>
            <button onclick="openAddModal()" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Procurement
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

        <!-- Table with integrated filter bar -->
        <?php
        $headers = [
            ['label' => 'Title', 'class' => ''],
            ['label' => 'Category', 'class' => 'w-36'],
            ['label' => 'PDF', 'class' => 'w-36'],
            ['label' => 'Status', 'class' => 'w-36'],
            ['label' => 'Date Added', 'class' => 'w-36'],
            ['label' => 'Actions', 'class' => 'text-right w-32']
        ];
        
        renderAdminTable($headers, $procurements, function($proc) {
            $statusClass = $proc['status'] === 'Published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-700 border-orange-200';
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group cursor-pointer" onclick="showPreviewModal(<?= $proc['id'] ?>, '<?= htmlspecialchars(addslashes($proc['title'])) ?>', 'manage-procurements?delete=<?= $proc['id'] ?>&csrf_token=<?= generateCsrfToken() ?>', <?= htmlspecialchars(json_encode($proc, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)">
                <td class="py-4 px-6">
                    <p class="text-[13.5px] font-bold text-slate-800 group-hover:text-secondary transition-colors leading-none mb-1"><?= htmlspecialchars($proc['title']) ?></p>
                    <?php if(!empty($proc['description'])): ?>
                        <p class="text-[11.5px] text-slate-400 truncate max-w-md mt-1.5" title="<?= htmlspecialchars(strip_tags($proc['description'])) ?>"><?= htmlspecialchars(strip_tags($proc['description'])) ?></p>
                    <?php endif; ?>
                    
                    <!-- Hidden Preview Content -->
                    <div id="preview-content-<?= $proc['id'] ?>" class="hidden">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-wrap gap-2">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold bg-slate-100 text-slate-600 border border-slate-200 shadow-sm"><?= htmlspecialchars($proc['category'] ?? 'Notice') ?></span>
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold border shadow-sm <?= $statusClass ?>"><?= htmlspecialchars($proc['status']) ?></span>
                                <span class="px-2.5 py-1 bg-gray-50 text-gray-600 border border-slate-100 text-[11px] font-bold rounded-md shadow-sm uppercase tracking-wider"><?= date('M d, Y', strtotime($proc['created_at'])) ?></span>
                            </div>
                            <?php if (!empty($proc['description'])): ?>
                                <div class="text-[13px] text-gray-700 leading-relaxed border-t border-gray-100 pt-4 prose max-w-none">
                                    <?= $proc['description'] ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($proc['pdf_path'])): ?>
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <a href="<?= htmlspecialchars(resolvePdfUrl($proc['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        View Attached PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <span class="px-2.5 py-1 rounded-md bg-slate-100 text-slate-600 border border-slate-200 text-[11px] font-bold shadow-sm"><?= htmlspecialchars($proc['category'] ?? 'Notice') ?></span>
                </td>
                <td class="py-4 px-6">
                    <a href="<?= htmlspecialchars(resolvePdfUrl($proc['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center text-secondary hover:text-[#721c1c] text-[13px] font-bold transition-colors">
                        <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        View PDF
                    </a>
                </td>
                <td class="py-4 px-6">
                    <?php if ($proc['status'] === 'Published'): ?>
                    <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                    <?php else: ?>
                    <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-[13px] text-slate-400 font-mono"><?= date('M d, Y', strtotime($proc['created_at'])) ?></td>
                <td class="py-4 px-6 text-right" onclick="event.stopPropagation();">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick='openEditModal(<?= json_encode($proc, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                        </button>
                        <a href="manage-procurements?delete=<?= $proc['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this procurement?" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'minWidth' => '900px',
            'emptyTitle' => 'No procurements found',
            'emptySubtitle' => 'There are no procurements matching your criteria.',
            'filters' => [
                'search' => ['placeholder' => 'Search by procurement title...', 'maxWidth' => '40%'],
                'filters' => [
                    [
                        'icon' => 'tag',
                        'placeholder' => 'All Categories',
                        'options' => ['Plan' => 'Plan', 'Notice' => 'Notice', 'Award' => 'Award']
                    ],
                    [
                        'icon' => 'status',
                        'placeholder' => 'All Statuses',
                        'options' => ['Published' => 'Published', 'Draft' => 'Draft']
                    ]
                ],
                'reset' => true
            ],
            'pagination' => [
                'total_items' => count($procurements),
                'showing_count' => count($procurements),
                'per_page' => 10,
                'enable_paging' => true
            ]
        ]);
        ?>

        <!-- Add/Edit Modal -->
        <div id="procModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
            <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeProcModal()"></div>
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden transform scale-95 transition-all duration-300 relative z-10 max-h-[90vh] flex flex-col border border-slate-100">
                <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50 shrink-0">
                    <h3 class="text-lg font-bold font-montserrat text-slate-800 flex items-center gap-2" id="modalTitle">
                        <!-- Filled by JS -->
                    </h3>
                    <button type="button" onclick="closeProcModal()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-50 p-1.5 rounded-lg transition-colors focus:outline-none">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto custom-scrollbar flex-1">
                    <form id="procForm" action="" method="POST" enctype="multipart/form-data" class="js-validate-form space-y-5">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="proc_id" id="procId" value="">
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="md:col-span-1">
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="procTitle" required placeholder="Procurement title" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 placeholder-slate-400 font-semibold">
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Category</label>
                                <div class="relative">
                                    <select name="category" id="procCategory" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-600 appearance-none cursor-pointer font-semibold">
                                        <option value="Plan">Procurement Plan</option>
                                        <option value="Notice">Procurement Notice</option>
                                        <option value="Award">Contract Award Details</option>
                                    </select>
                                    <span class="absolute inset-y-0 right-0 pr-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path></svg>
                                    </span>
                                </div>
                            </div>
                            <div>
                                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" id="procStatus" class="w-full pl-4 pr-10 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-600 appearance-none cursor-pointer font-semibold">
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
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Description (Optional)</label>
                            <input type="hidden" name="description" id="procDescriptionInput">
                            <div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden shadow-inner">
                                <div id="procDescription" style="height: 180px;"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2" id="pdfLabel">PDF File <span class="text-red-500">*</span></label>
                            
                            <!-- Premium Custom File Input -->
                            <div class="relative border-2 border-dashed border-slate-200 rounded-xl p-6 hover:border-primary transition-all bg-slate-50/50 flex flex-col items-center justify-center cursor-pointer group text-center" onclick="document.getElementById('procPdf').click()">
                                <svg class="w-8 h-8 text-slate-400 group-hover:text-primary transition-colors mb-2" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z" /></svg>
                                <span class="text-xs text-slate-500 font-bold uppercase tracking-wider block" id="pdfFileName">Select or drag PDF File</span>
                                <span class="text-[10px] text-slate-400 mt-1 block">Only PDF documents are accepted</span>
                                <input type="file" name="pdf_file" id="procPdf" accept="application/pdf" required class="hidden" onchange="showSelectedFileName(this)">
                            </div>
                            <p id="editPdfHint" class="text-[11px] text-slate-400 italic hidden mt-1.5">Leave blank if you wish to keep the currently uploaded PDF.</p>
                        </div>

                        <div class="pt-5 flex justify-end gap-3 border-t border-slate-100 mt-6 font-inter shrink-0">
                            <button type="button" onclick="closeProcModal()" class="px-5 py-2.5 bg-white border border-slate-200 text-slate-700 rounded-xl text-[12.5px] font-bold hover:bg-slate-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-gradient-to-r from-secondary to-[#721c1c] text-white rounded-xl text-[12.5px] font-bold hover:shadow-md hover:brightness-110 active:scale-[0.98] transition-all">
                                Save Procurement
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
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg> Add New Procurement';
            document.getElementById('formAction').value = 'add';
            document.getElementById('procId').value = '';
            
            document.getElementById('procTitle').value = '';
            document.getElementById('procCategory').value = 'Notice';
            quillProc.setText('');
            document.getElementById('procStatus').value = 'Published';
            document.getElementById('procPdf').value = '';
            
            document.getElementById('pdfFileName').textContent = "Select or drag PDF File";
            document.getElementById('pdfFileName').className = "text-xs text-slate-500 font-bold uppercase tracking-wider block";
            
            document.getElementById('procPdf').required = true;
            document.getElementById('pdfLabel').innerHTML = 'PDF File <span class="text-red-500">*</span>';
            document.getElementById('editPdfHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Procurement';
            
            const modal = document.getElementById('procModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function openEditModal(proc) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg> Edit Procurement';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('procId').value = proc.id;
            
            document.getElementById('procTitle').value = proc.title;
            document.getElementById('procCategory').value = proc.category || 'Notice';
            quillProc.root.innerHTML = proc.description || '';
            document.getElementById('procStatus').value = proc.status;
            document.getElementById('procPdf').value = '';
            
            if (proc.pdf_path) {
                const parts = proc.pdf_path.split('/');
                document.getElementById('pdfFileName').textContent = parts[parts.length - 1];
                document.getElementById('pdfFileName').className = "text-xs text-slate-700 font-bold uppercase tracking-wider block";
            } else {
                document.getElementById('pdfFileName').textContent = "Select or drag PDF File";
                document.getElementById('pdfFileName').className = "text-xs text-slate-500 font-bold uppercase tracking-wider block";
            }
            
            document.getElementById('procPdf').required = false;
            document.getElementById('pdfLabel').textContent = 'PDF File (New)';
            document.getElementById('editPdfHint').classList.remove('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Save Changes';
            
            const modal = document.getElementById('procModal');
            const modalBox = modal.querySelector('.bg-white');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            void modal.offsetWidth; // trigger reflow
            modal.classList.remove('opacity-0');
            modalBox.classList.remove('scale-95');
            modalBox.classList.add('scale-100');
        }

        function closeProcModal() {
            const modal = document.getElementById('procModal');
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
        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
        <script>
        // Initialize Quill editor
        const quillProc = new Quill('#procDescription', {
            theme: 'snow',
            modules: {
                toolbar: [
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    ['link'],
                    ['clean']
                ]
            }
        });

        // Sync Quill content to hidden input on form submit
        const form = document.getElementById('procForm');
        if (form) {
            form.addEventListener('submit', function() {
                const html = quillProc.root.innerHTML;
                document.getElementById('procDescriptionInput').value = (html === '<p><br></p>') ? '' : html;
            });
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

