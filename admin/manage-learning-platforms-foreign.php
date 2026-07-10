<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();

$current_page = "manage-learning-platforms-foreign";
$error = '';
$success = '';

// Handle Delete
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT pdf_path FROM learning_platforms_foreign WHERE id = ?");
    $stmt->execute([$del_id]);
    $pub = $stmt->fetch();
    
    if ($pub) {
        if (!empty($pub['pdf_path']) && file_exists($pub['pdf_path'])) {
            unlink($pub['pdf_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM learning_platforms_foreign WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Foreign Learning Platform deleted successfully.";
    } else {
        $error = "Foreign Learning Platform not found.";
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
                $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/learning_platforms', ['application/pdf'], 5242880);
                if ($uploadResult['success']) {
                    $pdf_path = $uploadResult['path'];
                    $stmt = $pdo->prepare("INSERT INTO learning_platforms_foreign (title, description, pdf_path, status) VALUES (?, ?, ?, ?)");
                    if ($stmt->execute([$title, $description, $pdf_path, $status])) {
                        $success = "Foreign Learning Platform added successfully.";
                    } else {
                        $error = "Failed to add learning_platform_foreign.";
                    }
                } else {
                    $error = $uploadResult['error'];
                }
            }
        } elseif ($action === 'edit') {
            $edit_id = (int)$_POST['pub_id'];
            
            $stmt = $pdo->prepare("SELECT pdf_path FROM learning_platforms_foreign WHERE id = ?");
            $stmt->execute([$edit_id]);
            $existing = $stmt->fetch();
            
            if (!$existing) {
                $error = "Foreign Learning Platform not found.";
            } else {
                $pdf_path = $existing['pdf_path'];
                
                // If new file uploaded
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = handleFileUpload($_FILES['pdf_file'], 'uploads/learning_platforms', ['application/pdf'], 5242880);
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
                    $stmt = $pdo->prepare("UPDATE learning_platforms_foreign SET title = ?, description = ?, pdf_path = ?, status = ? WHERE id = ?");
                    if ($stmt->execute([$title, $description, $pdf_path, $status, $edit_id])) {
                        $success = "Foreign Learning Platform updated successfully.";
                    } else {
                        $error = "Failed to update learning_platform_foreign.";
                    }
                }
            }
        }
    }
}

// Fetch Foreign Learning Platforms
$stmt = $pdo->query("SELECT * FROM learning_platforms_foreign ORDER BY created_at DESC");
$learning_platforms_foreign = $stmt->fetchAll();

include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<!-- Main wrapper -->
<div class="flex-1 flex flex-col min-w-0 bg-white relative z-10">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-10">
        <!-- Include Quill CSS -->
        <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
        
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-3xl font-bold font-montserrat text-gray-900">Manage Foreign Learning Platforms</h2>
            <button onclick="openAddModal()" class="bg-[#4E0000] text-white px-5 py-2.5 rounded-md text-[13px] font-semibold hover:bg-[#320000] transition-colors shadow-sm flex items-center">
                <span class="mr-1.5 text-lg leading-none">+</span> New Foreign Learning Platform
            </button>
        </div>

        
        

        <!-- Filter Bar -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 mb-6 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="relative flex-1 w-full md:max-w-[60%]">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" placeholder="Search by title..." class="js-table-search bg-[#FAFAFA] border border-[#E5E7EB] text-gray-900 text-[13px] rounded-lg focus:ring-secondary focus:border-secondary block w-full pl-10 pr-4 py-2.5 font-inter transition-colors outline-none shadow-sm placeholder-gray-400">
                </div>
            
            <div class="grid grid-cols-2 sm:flex sm:items-center gap-3 w-full sm:w-auto">
                <div class="relative w-full sm:w-40">
                    <select class="js-table-filter w-full pl-4 pr-10 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-md focus:outline-none focus:ring-1 focus:ring-gray-300 text-[13px] font-medium text-gray-700 appearance-none cursor-pointer hover:bg-gray-50 transition-colors">
                        <option value="">All Statuses</option>
                        <option value="Published">Published</option>
                        <option value="Draft">Draft</option>
                    </select>
                    <svg class="w-4 h-4 absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>

                <button class="js-reset-filter col-span-1 px-4 py-2.5 bg-white border border-red-200 rounded-md text-[13px] font-medium text-red-500 flex items-center justify-center hover:bg-red-50 transition-colors">
                    Reset
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden overflow-x-auto mb-12">
            <table class="js-filterable-table w-full text-left border-collapse">
                <thead>
                    <tr class="bg-[#F9FAFB] border-b border-gray-100">
                        <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Title</th>
                        <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">PDF</th>
                        <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider">Date Added</th>
                        <th class="py-4 px-6 text-[12px] font-semibold text-gray-500 uppercase tracking-wider text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    <?php if (empty($learning_platforms_foreign)): ?>
                    <tr>
                        <td colspan="5" class="py-16 px-6">
                            <div class="flex flex-col items-center justify-center text-center">
                                <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                                </div>
                                <p class="text-[14px] font-semibold text-gray-900 mb-1">No foreign learning platforms found</p>
                            </div>
                        </td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($learning_platforms_foreign as $pub): ?>
                    <tr class="hover:bg-gray-50 transition-colors cursor-pointer group" onclick="showPreviewModal(<?= $pub['id'] ?>, '<?= htmlspecialchars(addslashes($pub['title'])) ?>', 'manage-learning-platforms-foreign?delete=<?= $pub['id'] ?>&csrf_token=<?= generateCsrfToken() ?>', <?= htmlspecialchars(json_encode($pub, JSON_HEX_APOS | JSON_HEX_QUOT)) ?>)">
                        <td class="py-4 px-6">
                            <p class="text-[13px] font-medium text-gray-900 group-hover:text-[#4E0000] transition-colors"><?= htmlspecialchars($pub['title']) ?></p>
                            <?php if(!empty($pub['description'])): ?>
                                <p class="text-[12px] text-gray-500 truncate w-48" title="<?= htmlspecialchars($pub['description']) ?>"><?= htmlspecialchars($pub['description']) ?></p>
                            <?php endif; ?>
                            
                            <!-- Hidden Preview Content -->
                            <div id="preview-content-<?= $pub['id'] ?>" class="hidden">
                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-wrap gap-2">
                                        <span class="px-2.5 py-1 rounded text-[11px] font-bold <?= $pub['status'] === 'Published' ? 'bg-[#EDF7F4] text-[#166952]' : 'bg-[#FCF1F2] text-[#9E212D]' ?>"><?= htmlspecialchars($pub['status']) ?></span>
                                        <span class="px-2.5 py-1 bg-gray-100 text-gray-700 text-[11px] font-bold rounded uppercase tracking-wider"><?= date('M d, Y', strtotime($pub['created_at'])) ?></span>
                                    </div>
                                    <?php if (!empty($pub['description'])): ?>
                                        <div class="text-[13px] text-gray-700 leading-relaxed border-t border-gray-100 pt-4 prose max-w-none">
                                            <?= $pub['description'] ?>
                                        </div>
                                    <?php endif; ?>
                                    <?php if (!empty($pub['pdf_path'])): ?>
                                        <div class="border-t border-gray-100 pt-4 mt-2">
                                            <a href="<?= htmlspecialchars($pub['pdf_path']) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center px-4 py-2 bg-[#13273F] text-white rounded-lg text-xs font-semibold hover:bg-opacity-90 transition-colors shadow-sm">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                                View Attached PDF
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <a href="<?= htmlspecialchars($pub['pdf_path']) ?>" target="_blank" onclick="event.stopPropagation();" class="inline-flex items-center text-[#4E0000] hover:text-[#320000] text-[13px] font-semibold transition-colors">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                View PDF
                            </a>
                        </td>
                        <td class="py-4 px-6">
                            <?php if ($pub['status'] === 'Published'): ?>
                            <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-[#13273F] text-white">Published</span>
                            <?php else: ?>
                            <span class="px-2.5 py-1 rounded text-[11px] font-bold bg-gray-200 text-gray-800">Draft</span>
                            <?php endif; ?>
                        </td>
                        <td class="py-4 px-6 text-[13px] text-gray-600"><?= date('M d, Y', strtotime($pub['created_at'])) ?></td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <button onclick='event.stopPropagation(); openEditModal(<?= json_encode($pub, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="js-edit-row p-1.5 text-gray-400 hover:text-[#4E0000] transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                                <a href="manage-learning-platforms-foreign?delete=<?= $pub['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="event.stopPropagation();" data-confirm="Are you sure you want to delete this foreign learning platform?" class="p-1.5 text-gray-400 hover:text-red-500 transition-colors" title="Delete">
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

        <!-- Add/Edit Modal -->
        <div id="pubModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900 flex items-center" id="modalTitle">
                        <svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        Add New Foreign Learning Platform
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
                                <input type="text" name="title" id="pubTitle" required placeholder="Foreign Learning Platform title" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900 placeholder-gray-400">
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Status</label>
                                <div class="relative">
                                    <select name="status" id="pubStatus" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-600 appearance-none cursor-pointer">
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
                            <input type="file" name="pdf_file" id="pubPdf" accept="application/pdf" required class="w-full px-4 py-2.5 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-[#4E0000] text-[13px] text-gray-900">
                            <p id="editPdfHint" class="text-[12px] text-gray-500 hidden mt-2">Leave blank to keep current PDF.</p>
                        </div>

                        <div class="pt-4 mt-2 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closePubModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-medium hover:bg-gray-50 transition-colors">
                                Cancel
                            </button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-[#4E0000] text-white rounded-md text-[13px] font-bold hover:bg-[#320000] transition-colors shadow-sm">
                                Save Foreign Learning Platform
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openAddModal() {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg> Add New Foreign Learning Platform';
            document.getElementById('formAction').value = 'add';
            document.getElementById('pubId').value = '';
            
            document.getElementById('pubTitle').value = '';
            quillPub.setText('');
            document.getElementById('pubStatus').value = 'Published';
            document.getElementById('pubPdf').value = '';
            
            document.getElementById('pubPdf').required = true;
            document.getElementById('pdfLabel').innerHTML = 'PDF File <span class="text-red-500">*</span>';
            document.getElementById('editPdfHint').classList.add('hidden');
            
            document.getElementById('submitBtnText').textContent = 'Create Foreign Learning Platform';
            
            const modal = document.getElementById('pubModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(pub) {
            document.getElementById('modalTitle').innerHTML = '<svg class="w-5 h-5 mr-2 text-[#4E0000]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg> Edit Foreign Learning Platform';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('pubId').value = pub.id;
            
            document.getElementById('pubTitle').value = pub.title;
            quillPub.root.innerHTML = pub.description || '';
            document.getElementById('pubStatus').value = pub.status;
            document.getElementById('pubPdf').value = '';
            
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


