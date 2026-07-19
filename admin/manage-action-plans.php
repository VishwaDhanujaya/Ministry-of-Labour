<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_action_plans');

$current_page = "manage-action-plans";
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT pdf_path FROM action_plans WHERE id = ?");
    $stmt->execute([$del_id]);
    $pub = $stmt->fetch();
    
    if ($pub) {
        if (!empty($pub['pdf_path']) && file_exists($pub['pdf_path'])) {
            unlink($pub['pdf_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM action_plans WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Action Plan deleted successfully.";
    } else {
        $error = "Action Plan not found.";
    }
}

// Handle Add/Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    $title = trim($_POST['title']);
    $description = trim($_POST['description']);
    $status = $_POST['status'];
    
    if (empty($title)) {
        $error = "Title is required.";
    } else {
        if ($action === 'add') {
            if (!isset($_FILES['pdf_file']) || $_FILES['pdf_file']['error'] !== UPLOAD_ERR_OK) {
                $error = "PDF file is required.";
            } else {
                $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/action_plans', ['application/pdf'], 5242880);
                if ($uploadResult['success']) {
                    $pdf_path = $uploadResult['path'];
                    $stmt = $pdo->prepare("INSERT INTO action_plans (title, description, pdf_path, status) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$title, $description, $pdf_path, $status])) {
                        $success = "Action Plan added successfully.";
                    } else {
                        $error = "Failed to add action_plan.";
                    }
                } else {
                    $error = $uploadResult['error'];
                }
            }
        } elseif ($action === 'edit') {
            $edit_id = (int)$_POST['pub_id'];
            
            $stmt = $pdo->prepare("SELECT pdf_path FROM action_plans WHERE id = ?");
            $stmt->execute([$edit_id]);
            $existing = $stmt->fetch();
            
            if (!$existing) {
                $error = "Action Plan not found.";
            } else {
                $pdf_path = $existing['pdf_path'];
                
                // If new file uploaded
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/action_plans', ['application/pdf'], 5242880);
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
                    $stmt = $pdo->prepare("UPDATE action_plans SET title = ?, description = ?, pdf_path = ?, status = ? WHERE id = ?");
                    if ($stmt->execute([$title, $description, $pdf_path, $status, $edit_id])) {
                        $success = "Action Plan updated successfully.";
                    } else {
                        $error = "Failed to update action_plan.";
                    }
                }
            }
        }
    }
}

// Fetch Action Plans
$stmt = $pdo->query("SELECT * FROM action_plans ORDER BY created_at DESC");
$action_plans = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 bg-[#F8F9FA]">
        <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        


        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Action Plans</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Publish and manage educational resources, documents, and guides for the local workforce.</p>
            </div>
            <button onclick="openAddModal()" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto">
                <span class="mr-1.5 text-lg leading-none">+</span> New Platform Document
            </button>
        </div>

        
        

        <!-- Table with integrated filter bar -->
        <?php
        $headers = [
            ['label' => 'Title', 'class' => ''],
            ['label' => 'PDF', 'class' => 'w-36'],
            ['label' => 'Status', 'class' => 'w-36'],
            ['label' => 'Date Added', 'class' => 'w-36'],
            ['label' => 'Actions', 'class' => 'text-right w-32']
        ];
        
        renderAdminTable($headers, $action_plans, function($pub) {
            $statusClass = $pub['status'] === 'Published' ? 'bg-green-50 text-green-700 border-green-200' : 'bg-orange-50 text-orange-700 border-orange-200';
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group cursor-pointer" onclick="showPreviewModal(<?= $pub['id'] ?>, '<?= htmlspecialchars(addslashes($pub['title'])) ?>', 'manage-action-plans?delete=<?= $pub['id'] ?>&csrf_token=<?= generateCsrfToken() ?>', <?= htmlspecialchars(json_encode($pub, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)">
                <td class="py-4 px-6">
                    <p class="text-[13.5px] font-bold text-slate-800 group-hover:text-secondary transition-colors leading-none mb-1"><?= htmlspecialchars($pub['title']) ?></p>
                    <?php if(!empty($pub['description'])): ?>
                        <p class="text-[11.5px] text-slate-400 truncate max-w-md mt-1.5" title="<?= htmlspecialchars(strip_tags($pub['description'])) ?>"><?= htmlspecialchars(mb_strimwidth(strip_tags($pub['description']), 0, 80, '...')) ?></p>
                    <?php endif; ?>
                    
                    <!-- Hidden Preview Content -->
                    <div id="preview-content-<?= $pub['id'] ?>" class="hidden">
                        <div class="flex flex-col gap-4">
                            <div class="flex flex-wrap gap-2">
                                <span class="px-2.5 py-1 rounded-md text-[11px] font-bold border shadow-sm <?= $statusClass ?>"><?= htmlspecialchars($pub['status']) ?></span>
                                <span class="px-2.5 py-1 bg-gray-50 text-gray-600 border border-slate-100 text-[11px] font-bold rounded-md shadow-sm uppercase tracking-wider"><?= date('M d, Y', strtotime($pub['created_at'])) ?></span>
                            </div>
                            <?php if (!empty($pub['description'])): ?>
                                <div class="text-[13px] text-gray-700 leading-relaxed border-t border-gray-100 pt-4 prose max-w-none">
                                    <?= $pub['description'] ?>
                                </div>
                            <?php endif; ?>
                            <?php if (!empty($pub['pdf_path'])): ?>
                                <div class="border-t border-gray-100 pt-4 mt-2">
                                    <a href="<?= htmlspecialchars(resolvePdfUrl($pub['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center px-4 py-2 bg-primary text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition-colors shadow-sm">
                                        <svg class="w-4 h-4 mr-2 text-red-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                                        View Attached PDF
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td class="py-4 px-6">
                    <a href="<?= htmlspecialchars(resolvePdfUrl($pub['pdf_path'])) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center text-secondary hover:text-[#721c1c] text-[13px] font-bold transition-colors">
                        <svg class="w-4 h-4 mr-1.5 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                        View PDF
                    </a>
                </td>
                <td class="py-4 px-6">
                    <?php if ($pub['status'] === 'Published'): ?>
                    <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                    <?php else: ?>
                    <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-[13px] text-slate-400 font-mono"><?= date('M d, Y', strtotime($pub['created_at'])) ?></td>
                <td class="py-4 px-6 text-right" onclick="event.stopPropagation();">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick='openEditModal(<?= json_encode($pub, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                        </button>
                        <a href="manage-action-plans?delete=<?= $pub['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this learning platform?" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'minWidth' => '800px',
            'emptyTitle' => 'No Action Plans found',
            'emptySubtitle' => 'There are no platforms matching your criteria.',
            'filters' => [
                'search' => ['placeholder' => 'Search by title...', 'maxWidth' => '50%'],
                'filters' => [
                    [
                        'icon' => 'status',
                        'placeholder' => 'All Statuses',
                        'options' => ['Published' => 'Published', 'Draft' => 'Draft']
                    ]
                ],
                'reset' => true
            ],
            'pagination' => [
                'total_items' => count($action_plans),
                'showing_count' => count($action_plans),
                'per_page' => 10,
                'enable_paging' => true
            ]
        ]);
        ?>

        <!-- Add/Edit Modal -->
        <div id="pubModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 flex items-center" id="modalTitle">
                        <svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Add New Action Plan
                    </h3>
                    <button type="button" onclick="closePubModal()" class="text-gray-400 hover:text-gray-600 transition-colors bg-white hover:bg-gray-100 rounded-full p-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                
                <div class="p-6 overflow-y-auto">
                    <form id="pubForm" action="" method="POST" enctype="multipart/form-data" class="js-validate-form space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="pub_id" id="pubId" value="">
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Title <span class="text-red-500">*</span></label>
                                <input type="text" name="title" id="pubTitle" required placeholder="Action Plan title" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px] text-gray-900 placeholder-gray-400">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" id="pubStatus" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px] text-gray-600 appearance-none cursor-pointer">
                                        <option value="Published">Published</option>
                                        <option value="Draft">Draft</option>
                                    </select>
                                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Description (Optional)</label>
                            <input type="hidden" name="description" id="pubDescriptionInput">
                            <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
                                <div id="pubDescription" style="height: 150px;"></div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-[13px] font-medium text-gray-800 mb-2" id="pdfLabel">PDF File <span class="text-red-500">*</span></label>
                            <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-slate-200 border-dashed rounded-xl hover:border-primary transition-colors cursor-pointer bg-slate-50/50" onclick="document.getElementById('pubPdf').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-10 w-10 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <div class="flex text-[13px] text-slate-600 justify-center mt-2">
                                        <span class="relative cursor-pointer rounded-md font-bold text-primary hover:text-[#254974]">
                                            <span>Upload a PDF file</span>
                                            <input id="pubPdf" name="pdf_file" type="file" class="sr-only" accept="application/pdf" required onchange="document.getElementById('pdf-file-name-local').textContent = this.files[0] ? this.files[0].name : ''">
                                        </span>
                                        <p class="pl-1 text-slate-400">or drag and drop</p>
                                    </div>
                                    <p class="text-xs text-slate-400 mt-1">PDF document</p>
                                    <p id="pdf-file-name-local" class="text-xs font-bold text-emerald-600 mt-2"></p>
                                </div>
                            </div>
                            <p id="editPdfHint" class="text-[12px] text-gray-500 hidden mt-2">Leave blank to keep current PDF.</p>
                        </div>

                        <div class="pt-4 mt-2 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closePubModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-secondary text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                                Save Action Plan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Add New Action Plan';
            document.getElementById('formAction').value = 'add';
            document.getElementById('pubId').value = '';
            
            document.getElementById('pubTitle').value = '';
            quillPub.setText('');
            document.getElementById('pubStatus').value = 'Published';
            document.getElementById('pubPdf').value = '';
            document.getElementById('pdf-file-name-local').textContent = '';
            
            document.getElementById('pubPdf').required = true;
            document.getElementById('pdfLabel').innerHTML = 'PDF File <span class="text-red-500">*</span>';
            document.getElementById('editPdfHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Action Plan';
            
            const modal = document.getElementById('pubModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(pub) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit Action Plan';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('pubId').value = pub.id;
            
            document.getElementById('pubTitle').value = pub.title;
            quillPub.root.innerHTML = pub.description || '';
            document.getElementById('pubStatus').value = pub.status;
            document.getElementById('pubPdf').value = '';
            document.getElementById('pdf-file-name-local').textContent = '';
            
            document.getElementById('pubPdf').required = false;
            document.getElementById('pdfLabel').textContent = 'PDF File (New)';
            document.getElementById('editPdfHint').classList.remove('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Save Changes';
            
            const modal = document.getElementById('pubModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closePubModal() {
            const modal = document.getElementById('pubModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        
        // Include Quill JS
        </script>
        <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
        <script>
        // Initialize Quill editor
        const quillPub = new Quill('#pubDescription', {
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
        const form = document.getElementById('pubForm');
        if (form) {
            form.addEventListener('submit', function() {
                const html = quillPub.root.innerHTML;
                document.getElementById('pubDescriptionInput').value = (html === '<p><br></p>') ? '' : html;
            });
        }
        </script>

        <!-- Preview Modal -->
        <div id="preview-modal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-opacity duration-300 opacity-0 bg-black/50 backdrop-blur-sm">
            <div class="absolute inset-0" onclick="hidePreviewModal()"></div>
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
                        <button id="preview-edit-btn" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-bold hover:bg-gray-50 transition-colors shadow-sm">Edit</button>
                        <a id="preview-delete-btn" href="#" data-confirm="Are you sure you want to delete this?" class="px-5 py-2 bg-red-600 text-white rounded-md text-[13px] font-bold hover:bg-red-700 transition-colors shadow-sm">Delete</a>
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

<?php include 'includes/footer.php'; ?>




