<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_iau');

// Handle AJAX image deletion
if (isset($_GET['delete_image_ajax'])) {
    header('Content-Type: application/json');
    requireCsrfToken('GET', 'get');
    $img_id = (int)$_GET['delete_image_ajax'];
    
    $stmt = $pdo->prepare("SELECT image_path FROM iau_update_images WHERE id = ?");
    $stmt->execute([$img_id]);
    $img = $stmt->fetch();
    if ($img) {
        if (!empty($img['image_path']) && file_exists('../' . $img['image_path'])) {
            @unlink('../' . $img['image_path']);
        }
        $stmt = $pdo->prepare("DELETE FROM iau_update_images WHERE id = ?");
        $stmt->execute([$img_id]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Image not found']);
    }
    exit;
}

$current_page = "manage-iau-updates";
$error = '';
$success = '';

// Handle Delete Album
if (isset($_GET['delete'])) {
    requireCsrfToken('GET', 'get');
    $del_id = (int)$_GET['delete'];
    
    $stmt = $pdo->prepare("SELECT cover_image FROM iau_updates WHERE id = ?");
    $stmt->execute([$del_id]);
    $notice = $stmt->fetch();
    
    if ($notice) {
        // Delete cover
        if (!empty($notice['cover_image']) && file_exists('../' . $notice['cover_image'])) {
            @unlink('../' . $notice['cover_image']);
        }
        // Delete all slide images
        $imgStmt = $pdo->prepare("SELECT image_path FROM iau_update_images WHERE update_id = ?");
        $imgStmt->execute([$del_id]);
        while ($img = $imgStmt->fetch()) {
            if (!empty($img['image_path']) && file_exists('../' . $img['image_path'])) {
                @unlink('../' . $img['image_path']);
            }
        }
        $pdo->prepare("DELETE FROM iau_update_images WHERE update_id = ?")->execute([$del_id]);
        
        // Delete Album
        $stmt = $pdo->prepare("DELETE FROM iau_updates WHERE id = ?");
        $stmt->execute([$del_id]);
        $success = "Album deleted successfully.";
    } else {
        $error = "Album not found.";
    }
}

// Handle Add/Edit Album
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'];
    $title_en = trim($_POST['title_en'] ?? '');
    $title_si = isset($_POST['title_si']) ? trim($_POST['title_si']) : null;
    $title_ta = isset($_POST['title_ta']) ? trim($_POST['title_ta']) : null;
    $is_active = (int)$_POST['is_active'];
    
    // Fallback if trilingual helper posts title instead of title_en
    if (empty($title_en) && isset($_POST['title'])) {
        $title_en = trim($_POST['title']);
    }
    
    $title_err = validateTrilingualFields([$title_en, $title_si, $title_ta], 'Title');
    
    if (empty($title_en)) {
        $error = "Title (English) is required.";
    } elseif ($title_err) {
        $error = $title_err;
    } else {
        if ($action === 'add') {
            $cover_image = '';
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                $uploadResult = handleFileUpload($_FILES['cover_image'], '../assets/img/IAU', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                if ($uploadResult['success']) $cover_image = str_replace('../', '', $uploadResult['path']);
                else $error = $uploadResult['error'];
            }
            
            if (empty($error)) {
                $stmt = $pdo->prepare("INSERT INTO iau_updates (title_en, title_si, title_ta, cover_image, is_active) VALUES (?, ?, ?, ?, ?)");
                if ($stmt->execute([$title_en, $title_si, $title_ta, $cover_image, $is_active])) {
                    $album_id = $pdo->lastInsertId();
                    
                    // Handle additional images
                    if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                        $file_count = count($_FILES['additional_images']['name']);
                        for ($i = 0; $i < $file_count; $i++) {
                            if ($_FILES['additional_images']['error'][$i] === UPLOAD_ERR_OK) {
                                $file = [
                                    'name' => $_FILES['additional_images']['name'][$i],
                                    'type' => $_FILES['additional_images']['type'][$i],
                                    'tmp_name' => $_FILES['additional_images']['tmp_name'][$i],
                                    'error' => $_FILES['additional_images']['error'][$i],
                                    'size' => $_FILES['additional_images']['size'][$i]
                                ];
                                $uploadResult = handleFileUpload($file, '../assets/img/IAU', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                                if ($uploadResult['success']) {
                                    $img_path = str_replace('../', '', $uploadResult['path']);
                                    $stmt_img = $pdo->prepare("INSERT INTO iau_update_images (update_id, image_path, sort_order) VALUES (?, ?, 0)");
                                    $stmt_img->execute([$album_id, $img_path]);
                                }
                            }
                        }
                    }
                    $success = "Album added successfully.";
                } else {
                    $error = "Failed to add album.";
                }
            }
        } elseif ($action === 'edit') {
            $edit_id = (int)$_POST['update_id'];
            
            $stmt = $pdo->prepare("SELECT cover_image FROM iau_updates WHERE id = ?");
            $stmt->execute([$edit_id]);
            $existing = $stmt->fetch();
            
            if (!$existing) {
                $error = "Album not found.";
            } else {
                $cover_image = $existing['cover_image'];
                if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] === UPLOAD_ERR_OK) {
                    $uploadResult = handleFileUpload($_FILES['cover_image'], '../assets/img/IAU', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                    if ($uploadResult['success']) {
                        if (!empty($cover_image) && file_exists('../' . $cover_image)) @unlink('../' . $cover_image);
                        $cover_image = str_replace('../', '', $uploadResult['path']);
                    } else $error = $uploadResult['error'];
                }
                
                if (empty($error)) {
                    $stmt = $pdo->prepare("UPDATE iau_updates SET title_en = ?, title_si = ?, title_ta = ?, cover_image = ?, is_active = ? WHERE id = ?");
                    if ($stmt->execute([$title_en, $title_si, $title_ta, $cover_image, $is_active, $edit_id])) {
                        
                        // Handle additional images
                        if (isset($_FILES['additional_images']) && !empty($_FILES['additional_images']['name'][0])) {
                            $file_count = count($_FILES['additional_images']['name']);
                            for ($i = 0; $i < $file_count; $i++) {
                                if ($_FILES['additional_images']['error'][$i] === UPLOAD_ERR_OK) {
                                    $file = [
                                        'name' => $_FILES['additional_images']['name'][$i],
                                        'type' => $_FILES['additional_images']['type'][$i],
                                        'tmp_name' => $_FILES['additional_images']['tmp_name'][$i],
                                        'error' => $_FILES['additional_images']['error'][$i],
                                        'size' => $_FILES['additional_images']['size'][$i]
                                    ];
                                    $uploadResult = handleFileUpload($file, '../assets/img/IAU', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                                    if ($uploadResult['success']) {
                                        $img_path = str_replace('../', '', $uploadResult['path']);
                                        $stmt_img = $pdo->prepare("INSERT INTO iau_update_images (update_id, image_path, sort_order) VALUES (?, ?, 0)");
                                        $stmt_img->execute([$edit_id, $img_path]);
                                    }
                                }
                            }
                        }
                        $success = "Album updated successfully.";
                    } else {
                        $error = "Failed to update album.";
                    }
                }
            }
        }
    }
    
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest') {
        header('Content-Type: application/json');
        if (!empty($error)) {
            echo json_encode(['success' => false, 'error' => $error]);
        } else {
            echo json_encode(['success' => true, 'message' => $success]);
        }
        exit;
    }
}

// Fetch albums with their corresponding additional images
$stmt = $pdo->query("SELECT * FROM iau_updates ORDER BY created_at DESC");
$updates = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($updates as &$u) {
    $imgStmt = $pdo->prepare("SELECT id, image_path FROM iau_update_images WHERE update_id = ? ORDER BY sort_order ASC, id DESC");
    $imgStmt->execute([$u['id']]);
    $u['images'] = $imgStmt->fetchAll(PDO::FETCH_ASSOC);
}
unset($u);

$pageTitle = 'Manage IAU Updates (Gallery)';
include 'includes/header.php'; 
?>
<?php include 'includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8 bg-[#F8F9FA]">


        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage IAU Updates (Gallery)</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Manage image galleries for IAU activities.</p>
            </div>
            <button onclick="openAddModal()" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto gap-1.5">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                New Album
            </button>
        </div>

        <?php
        $headers = [
            ['label' => 'Cover', 'class' => 'w-24'],
            ['label' => 'Title', 'class' => ''],
            ['label' => 'Status', 'class' => 'w-36'],
            ['label' => 'Actions', 'class' => 'text-right w-40']
        ];
        
        renderAdminTable($headers, $updates, function($update) {
            ?>
            <tr class="hover:bg-slate-50/60 bg-white border-b border-slate-50/70 transition-all duration-150 group">
                <td class="py-4 px-6">
                    <?php if(!empty($update['cover_image'])): ?>
                        <img src="../<?= htmlspecialchars($update['cover_image']) ?>" class="w-12 h-12 rounded object-cover border border-gray-200">
                    <?php else: ?>
                        <div class="w-12 h-12 rounded bg-gray-100 flex items-center justify-center border border-gray-200"><span class="text-xs text-gray-400">No Img</span></div>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6">
                    <p class="text-[13.5px] font-bold text-slate-800 leading-none mb-1"><?= htmlspecialchars($update['title_en']) ?></p>
                </td>
                <td class="py-4 px-6">
                    <?php if ($update['is_active']): ?>
                    <span class="px-2.5 py-1 rounded-md bg-green-50 text-green-700 border border-green-200 text-[11px] font-bold shadow-sm">Published</span>
                    <?php else: ?>
                    <span class="px-2.5 py-1 rounded-md bg-orange-50 text-orange-700 border border-orange-200 text-[11px] font-bold shadow-sm">Draft</span>
                    <?php endif; ?>
                </td>
                <td class="py-4 px-6 text-right">
                    <div class="flex items-center justify-end gap-1.5">
                        <button onclick='openEditModal(<?= json_encode($update, JSON_HEX_APOS | JSON_HEX_QUOT) ?>)' class="w-8.5 h-8.5 rounded-xl bg-slate-50 border border-slate-100 hover:bg-slate-100 hover:text-slate-800 text-slate-400 flex items-center justify-center transition-all shadow-sm" title="Edit">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10"></path></svg>
                        </button>
                        <a href="manage-iau-updates?delete=<?= $update['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" data-confirm="Are you sure you want to delete this album?" class="w-8.5 h-8.5 rounded-xl bg-rose-50/50 border border-rose-100/50 hover:bg-rose-50 hover:text-rose-600 text-rose-400 flex items-center justify-center transition-all shadow-sm" title="Delete">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </a>
                    </div>
                </td>
            </tr>
            <?php
        }, [
            'minWidth' => '600px',
            'emptyTitle' => 'No albums found',
            'emptySubtitle' => 'There are no gallery albums matching your criteria.',
            'pagination' => ['total_items' => count($updates), 'showing_count' => count($updates), 'per_page' => 10, 'enable_paging' => true]
        ]);
        ?>

        <!-- Modal Form -->
        <div id="updateModal" class="fixed inset-0 z-[150] hidden items-center justify-center bg-black/50 backdrop-blur-sm p-4">
            <div class="bg-white rounded-xl shadow-xl w-full max-w-2xl overflow-hidden transform transition-all flex flex-col max-h-[90vh]">
                <div class="flex justify-between items-center p-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold font-montserrat text-gray-900" id="modalTitle">Add New Album</h3>
                    <button type="button" onclick="closeUpdateModal()" class="text-gray-400 hover:text-gray-600 transition-colors bg-white hover:bg-gray-100 rounded-full p-1"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
                
                <div class="p-6 overflow-y-auto">
                    <form id="updateForm" action="" method="POST" enctype="multipart/form-data" class="space-y-6">
                        <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
                        <input type="hidden" name="action" id="formAction" value="add">
                        <input type="hidden" name="update_id" id="updateId" value="">
                        
                        <?php renderTrilingualInputFields([
                            'tab_group_id' => 'album-tabs',
                            'fields' => [
                                ['name' => 'title', 'label' => 'Album Title', 'type' => 'input', 'id_prefix' => 'albumTitle', 'required' => true]
                            ]
                        ]); ?>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-5">
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Status</label>
                                <select name="is_active" id="updateStatus" class="w-full px-4 py-3 bg-[#F9FAFB] border border-gray-100 rounded-lg focus:outline-none focus:ring-1 focus:ring-secondary text-[13px]">
                                    <option value="1">Published</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-[13px] font-medium text-gray-800 mb-2">Cover Image</label>
                                <div class="mt-1 flex justify-center px-4 py-4 border-2 border-slate-200 border-dashed rounded-xl hover:border-secondary transition-all duration-150 cursor-pointer bg-slate-50/50" onclick="document.getElementById('cover_image').click()">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-8 w-8 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 01-2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div class="flex text-[11px] text-slate-600 justify-center">
                                            <span class="relative cursor-pointer rounded-md font-bold text-secondary hover:brightness-110 focus-within:outline-none">
                                                <span>Upload cover</span>
                                                <input id="cover_image" name="cover_image" type="file" class="sr-only" accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewSingleImage(this, 'cover-preview')">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="cover-preview" class="mt-4 flex gap-4 flex-wrap"></div>

                        <!-- Additional Images dropzone -->
                        <div class="mt-5">
                            <label class="block text-[13px] font-medium text-gray-800 mb-2">Additional Images (Optional)</label>
                            <div class="mt-1 flex justify-center px-4 py-4 border-2 border-slate-200 border-dashed rounded-xl hover:border-secondary transition-all duration-150 cursor-pointer bg-slate-50/50" onclick="document.getElementById('additional_images').click()">
                                <div class="space-y-1 text-center">
                                    <svg class="mx-auto h-8 w-8 text-slate-400" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 01-2.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <div class="flex text-[11px] text-slate-600 justify-center">
                                        <span class="relative cursor-pointer rounded-md font-bold text-secondary hover:brightness-110 focus-within:outline-none">
                                            <span>Upload additional images</span>
                                            <input id="additional_images" name="additional_images[]" type="file" class="sr-only" multiple accept="image/png, image/jpeg, image/jpg, image/webp" onchange="previewMultipleImages(this, 'additional-preview')">
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div id="existing-images-preview" class="mt-4 flex gap-4 flex-wrap"></div>
                            <div id="additional-preview" class="mt-4 flex gap-4 flex-wrap"></div>
                        </div>

                        <div class="pt-4 mt-2 flex justify-end gap-3 border-t border-gray-100">
                            <button type="button" onclick="closeUpdateModal()" class="px-5 py-2.5 bg-white border border-gray-300 text-gray-700 rounded-md text-[13px] font-medium">Cancel</button>
                            <button type="submit" id="submitBtnText" class="px-6 py-2.5 bg-secondary text-white rounded-md text-[13px] font-bold">Save Album</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        let selectedAdditionalFiles = [];

        window.previewSingleImage = function(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    showToast('Cover image size exceeds the maximum limit of 5MB.', 'error');
                    input.value = '';
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<div class="relative group"><img loading="lazy" src="${e.target.result}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-[10px] font-bold px-2 text-center">New</span></div></div>`;
                }
                reader.readAsDataURL(file);
            }
        }

        window.previewMultipleImages = function(input, previewId) {
            const preview = document.getElementById(previewId);
            if (!input.files) return;

            const maxSize = 5 * 1024 * 1024;
            let newFiles = Array.from(input.files);
            let hasLargeFile = false;
            let acceptedFiles = [];

            newFiles.forEach(file => {
                if (file.size > maxSize) {
                    hasLargeFile = true;
                } else {
                    acceptedFiles.push(file);
                }
            });

            if (hasLargeFile) {
                showToast('One or more selected images exceed 5MB and were skipped.', 'error');
            }

            selectedAdditionalFiles = selectedAdditionalFiles.concat(acceptedFiles);
            syncAdditionalFilesInput(input);
            renderAdditionalPreviews(preview, input);
        }

        function syncAdditionalFilesInput(input) {
            if (typeof DataTransfer === 'undefined') return;
            const dt = new DataTransfer();
            selectedAdditionalFiles.forEach(file => dt.items.add(file));
            input.files = dt.files;
        }

        function renderAdditionalPreviews(previewDiv, input) {
            previewDiv.innerHTML = '';
            selectedAdditionalFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'relative group';
                    itemDiv.innerHTML = `
                        <img loading="lazy" src="${e.target.result}" class="h-20 w-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                        <div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg">
                            <span class="text-white text-[9px] font-bold px-1 text-center">New</span>
                        </div>
                        <button type="button" onclick="removeAdditionalFile(${index}, '${previewDiv.id}', '${input.id}')" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    `;
                    previewDiv.appendChild(itemDiv);
                }
                reader.readAsDataURL(file);
            });
        }

        window.removeAdditionalFile = function(index, previewId, inputId) {
            selectedAdditionalFiles.splice(index, 1);
            const input = document.getElementById(inputId);
            const preview = document.getElementById(previewId);
            syncAdditionalFilesInput(input);
            renderAdditionalPreviews(preview, input);
        }

        async function deleteExistingImage(imgId, btnElement) {
            if (!confirm('Are you sure you want to delete this image permanently?')) return;
            const csrfToken = '<?= generateCsrfToken() ?>';
            try {
                const res = await fetch(`manage-iau-updates?delete_image_ajax=${imgId}&csrf_token=${csrfToken}`);
                const data = await res.json();
                if (data.success) {
                    btnElement.closest('.relative').remove();
                    showToast('Image deleted successfully.', 'success');
                } else {
                    showToast(data.error || 'Failed to delete image.', 'error');
                }
            } catch (err) {
                showToast('Failed to delete image.', 'error');
                console.error(err);
            }
        }

        function openAddModal() {
            document.getElementById('modalTitle').textContent = 'Add New Album';
            document.getElementById('formAction').value = 'add';
            document.getElementById('updateId').value = '';
            document.getElementById('albumTitleEn').value = '';
            document.getElementById('albumTitleSi').value = '';
            document.getElementById('albumTitleTa').value = '';
            document.getElementById('updateStatus').value = '1';
            document.getElementById('submitBtnText').textContent = 'Create Album';
            
            document.getElementById('cover-preview').innerHTML = '';
            document.getElementById('existing-images-preview').innerHTML = '';
            document.getElementById('additional-preview').innerHTML = '';
            
            selectedAdditionalFiles = [];
            document.getElementById('cover_image').value = '';
            document.getElementById('additional_images').value = '';

            const modal = document.getElementById('updateModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function openEditModal(update) {
            document.getElementById('modalTitle').textContent = 'Edit Album';
            document.getElementById('formAction').value = 'edit';
            document.getElementById('updateId').value = update.id;
            document.getElementById('albumTitleEn').value = update.title_en;
            document.getElementById('albumTitleSi').value = update.title_si || '';
            document.getElementById('albumTitleTa').value = update.title_ta || '';
            document.getElementById('updateStatus').value = update.is_active;
            document.getElementById('submitBtnText').textContent = 'Save Changes';
            
            // Previews
            const coverPreview = document.getElementById('cover-preview');
            if (update.cover_image) {
                coverPreview.innerHTML = `<div class="relative group"><img loading="lazy" src="../${update.cover_image}" class="h-24 w-24 object-cover rounded-lg border border-gray-200 shadow-sm"><div class="absolute inset-0 bg-black bg-opacity-40 flex justify-center items-center opacity-0 group-hover:opacity-100 transition-opacity rounded-lg"><span class="text-white text-[10px] font-bold px-2 text-center">Current</span></div></div>`;
            } else {
                coverPreview.innerHTML = '';
            }
            
            selectedAdditionalFiles = [];
            document.getElementById('additional-preview').innerHTML = '';
            document.getElementById('cover_image').value = '';
            document.getElementById('additional_images').value = '';

            const existingPreview = document.getElementById('existing-images-preview');
            existingPreview.innerHTML = '';
            if (update.images && update.images.length > 0) {
                update.images.forEach(img => {
                    const itemDiv = document.createElement('div');
                    itemDiv.className = 'relative group';
                    itemDiv.innerHTML = `
                        <img loading="lazy" src="../${img.image_path}" class="h-20 w-20 object-cover rounded-lg border border-gray-200 shadow-sm">
                        <button type="button" onclick="deleteExistingImage(${img.id}, this)" class="absolute top-1 right-1 bg-red-500 text-white p-1 rounded-md opacity-0 group-hover:opacity-100 transition-opacity">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    `;
                    existingPreview.appendChild(itemDiv);
                });
            }
            
            const modal = document.getElementById('updateModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeUpdateModal() {
            document.getElementById('updateModal').classList.add('hidden');
            document.getElementById('updateModal').classList.remove('flex');
        }
        </script>

    </main>
    <?php include 'includes/footer.php'; ?>
</div>
