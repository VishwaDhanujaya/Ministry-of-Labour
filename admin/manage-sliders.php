<?php 
require_once 'includes/db.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';
requireLogin();
requirePermission('manage_sliders');

// Handle Reorder, Status Toggle, and Dropzone Uploads via AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    try {
        $token = $_POST['csrf_token'] ?? '';
        if (!verifyCsrfToken($token)) {
            echo json_encode(['success' => false, 'message' => 'CSRF Token validation failed. Please refresh page.']);
            exit;
        }

        $action = $_POST['action'];

        // 1. Reorder Sliders
        if ($action === 'reorder_sliders') {
            $slider_ids = $_POST['slider_ids'] ?? [];
            if (is_array($slider_ids)) {
                $stmt = $pdo->prepare("UPDATE hero_sliders SET display_order = ? WHERE id = ?");
                foreach ($slider_ids as $index => $id) {
                    $stmt->execute([$index + 1, (int)$id]);
                }
            }
            echo json_encode(['success' => true]);
            exit;
        }

        // 2. Toggle Single Slider Active Status
        if ($action === 'toggle_slider_status') {
            $slider_id = (int)$_POST['slider_id'];
            $stmt = $pdo->prepare("SELECT is_active FROM hero_sliders WHERE id = ?");
            $stmt->execute([$slider_id]);
            $s = $stmt->fetch();
            if ($s) {
                $newStatus = $s['is_active'] ? 0 : 1;
                $update = $pdo->prepare("UPDATE hero_sliders SET is_active = ? WHERE id = ?");
                $update->execute([$newStatus, $slider_id]);
                echo json_encode(['success' => true, 'is_active' => $newStatus]);
                exit;
            }
            echo json_encode(['success' => false, 'message' => 'Slider photo not found.']);
            exit;
        }

        // 3. Upload Dropzone Images via AJAX (Handles multi-file or single file sequentially)
        if ($action === 'upload_dropzone_images') {
            $batch_id = (int)$_POST['batch_id'];
            $uploaded = [];
            $errors = [];

            $filesToProcess = [];
            if (isset($_FILES['images']) && is_array($_FILES['images']['name'])) {
                $fileCount = count($_FILES['images']['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    $filesToProcess[] = [
                        'name' => $_FILES['images']['name'][$i],
                        'type' => $_FILES['images']['type'][$i],
                        'tmp_name' => $_FILES['images']['tmp_name'][$i],
                        'error' => $_FILES['images']['error'][$i],
                        'size' => $_FILES['images']['size'][$i]
                    ];
                }
            } elseif (isset($_FILES['images']) && is_string($_FILES['images']['name'])) {
                $filesToProcess[] = $_FILES['images'];
            }

            foreach ($filesToProcess as $singleFile) {
                if ($singleFile['error'] === UPLOAD_ERR_OK) {
                    $res = handleFileUpload($singleFile, 'uploads/sliders', ['image/jpeg', 'image/png', 'image/webp'], 10485760);
                    if ($res['success']) {
                        $path = preg_replace('/^\.\.\//', '', $res['path']);
                        $orderStmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 FROM hero_sliders WHERE batch_id = ?");
                        $orderStmt->execute([$batch_id]);
                        $nextOrder = (int)$orderStmt->fetchColumn();

                        $insert = $pdo->prepare("INSERT INTO hero_sliders (batch_id, image, display_order, is_active) VALUES (?, ?, ?, 1)");
                        $insert->execute([$batch_id, $path, $nextOrder]);
                        $id = $pdo->lastInsertId();
                        $uploaded[] = [
                            'id' => $id,
                            'image' => $path,
                            'filename' => basename($path),
                            'display_order' => $nextOrder
                        ];
                    } else {
                        $errors[] = $res['error'] ?? 'File upload error.';
                    }
                } elseif ($singleFile['error'] === UPLOAD_ERR_INI_SIZE || $singleFile['error'] === UPLOAD_ERR_FORM_SIZE) {
                    $errors[] = 'File size exceeds PHP upload limit.';
                } else {
                    $errors[] = 'Upload error code: ' . $singleFile['error'];
                }
            }

            if (!empty($uploaded)) {
                echo json_encode(['success' => true, 'uploaded' => $uploaded, 'errors' => $errors]);
            } else {
                echo json_encode(['success' => false, 'message' => !empty($errors) ? implode(' ', $errors) : 'No valid images were uploaded.']);
            }
            exit;
        }
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

$current_page = "manage-sliders";
$error = '';
$success = isset($_GET['success']) ? sanitizeInput($_GET['success']) : '';

// Handle Force Active Toggle
if (isset($_GET['force_batch'])) {
    requireCsrfToken('GET', 'get');
    $batch_id = (int)$_GET['force_batch'];
    
    $stmt = $pdo->prepare("SELECT is_forced FROM slider_batches WHERE id = ?");
    $stmt->execute([$batch_id]);
    $batch = $stmt->fetch();
    
    if ($batch) {
        $new_forced = $batch['is_forced'] ? 0 : 1;
        if ($new_forced) {
            $pdo->exec("UPDATE slider_batches SET is_forced = 0");
            $stmt = $pdo->prepare("UPDATE slider_batches SET is_forced = 1, is_active = 1 WHERE id = ?");
            $stmt->execute([$batch_id]);
        } else {
            $stmt = $pdo->prepare("UPDATE slider_batches SET is_forced = 0 WHERE id = ?");
            $stmt->execute([$batch_id]);
        }
        $msg = $new_forced ? "Batch successfully forced active for homepage!" : "Manual override disabled. Returned to automatic monthly cycling.";
        header("Location: manage-sliders?tab=" . $batch_id . "&success=" . urlencode($msg));
        exit;
    }
}

// Handle Batch Active Status Toggle
if (isset($_GET['toggle_batch_active'])) {
    requireCsrfToken('GET', 'get');
    $batch_id = (int)$_GET['toggle_batch_active'];
    
    $stmt = $pdo->prepare("SELECT is_active FROM slider_batches WHERE id = ?");
    $stmt->execute([$batch_id]);
    $batch = $stmt->fetch();
    if ($batch) {
        $new_active = $batch['is_active'] ? 0 : 1;
        $stmt = $pdo->prepare("UPDATE slider_batches SET is_active = ? WHERE id = ?");
        $stmt->execute([$new_active, $batch_id]);
        header("Location: manage-sliders?tab=" . $batch_id . "&success=" . urlencode("Batch active status updated."));
        exit;
    }
}

// Handle Batch Delete
if (isset($_GET['delete_batch'])) {
    requireCsrfToken('GET', 'get');
    $del_batch_id = (int)$_GET['delete_batch'];
    
    $stmt = $pdo->prepare("SELECT image FROM hero_sliders WHERE batch_id = ?");
    $stmt->execute([$del_batch_id]);
    $sliders = $stmt->fetchAll();
    foreach ($sliders as $s) {
        $file_to_delete = (strpos($s['image'], 'uploads/') === 0) ? $s['image'] : '../' . $s['image'];
        if (!empty($s['image']) && file_exists($file_to_delete)) {
            @unlink($file_to_delete);
        }
    }
    
    $stmt = $pdo->prepare("DELETE FROM slider_batches WHERE id = ?");
    $stmt->execute([$del_batch_id]);
    header("Location: manage-sliders?success=" . urlencode("Slider batch deleted successfully."));
    exit;
}

// Handle Slider Delete
if (isset($_GET['delete_slider'])) {
    requireCsrfToken('GET', 'get');
    $del_slider_id = (int)$_GET['delete_slider'];
    $tab_id = isset($_GET['tab']) ? (int)$_GET['tab'] : 0;
    
    $stmt = $pdo->prepare("SELECT image, batch_id FROM hero_sliders WHERE id = ?");
    $stmt->execute([$del_slider_id]);
    $slider = $stmt->fetch();
    if ($slider) {
        $file_to_delete = (strpos($slider['image'], 'uploads/') === 0) ? $slider['image'] : '../' . $slider['image'];
        if (!empty($slider['image']) && file_exists($file_to_delete)) {
            @unlink($file_to_delete);
        }
        $stmt = $pdo->prepare("DELETE FROM hero_sliders WHERE id = ?");
        $stmt->execute([$del_slider_id]);
        $target_tab = $tab_id ?: $slider['batch_id'];
        header("Location: manage-sliders?tab=" . $target_tab . "&success=" . urlencode("Slider photo deleted successfully."));
        exit;
    }
}

// Handle Batch Form Actions (Add / Edit) with Optional Multi-File Upload
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['form_type']) && $_POST['form_type'] === 'batch') {
    requireCsrfToken('POST', 'post');
    $action = $_POST['action'] ?? 'add';
    $batch_name = trim($_POST['batch_name'] ?? '');
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (empty($batch_name)) {
        $error = "Batch name is required.";
    } else {
        $batch_id = null;
        if ($action === 'add') {
            $stmt = $pdo->prepare("INSERT INTO slider_batches (batch_name, is_active) VALUES (?, ?)");
            if ($stmt->execute([$batch_name, $is_active])) {
                $batch_id = $pdo->lastInsertId();
            } else {
                $error = "Failed to create batch.";
            }
        } elseif ($action === 'edit') {
            $batch_id = (int)$_POST['batch_id'];
            $stmt = $pdo->prepare("UPDATE slider_batches SET batch_name = ?, is_active = ? WHERE id = ?");
            if (!$stmt->execute([$batch_name, $is_active, $batch_id])) {
                $error = "Failed to update batch.";
            }
        }

        // Process multiple file uploads if provided in batch form
        if (empty($error) && !empty($batch_id) && isset($_FILES['batch_images']) && is_array($_FILES['batch_images']['name'])) {
            $fileCount = count($_FILES['batch_images']['name']);
            for ($i = 0; $i < $fileCount; $i++) {
                if ($_FILES['batch_images']['error'][$i] === UPLOAD_ERR_OK) {
                    $singleFile = [
                        'name' => $_FILES['batch_images']['name'][$i],
                        'type' => $_FILES['batch_images']['type'][$i],
                        'tmp_name' => $_FILES['batch_images']['tmp_name'][$i],
                        'error' => $_FILES['batch_images']['error'][$i],
                        'size' => $_FILES['batch_images']['size'][$i]
                    ];
                    $uploadResult = handleFileUpload($singleFile, 'uploads/sliders', ['image/jpeg', 'image/png', 'image/webp'], 10485760);
                    if ($uploadResult['success']) {
                        $image_path = preg_replace('/^\.\.\//', '', $uploadResult['path']);
                        $orderStmt = $pdo->prepare("SELECT COALESCE(MAX(display_order), 0) + 1 FROM hero_sliders WHERE batch_id = ?");
                        $orderStmt->execute([$batch_id]);
                        $nextOrder = (int)$orderStmt->fetchColumn();

                        $stmt = $pdo->prepare("INSERT INTO hero_sliders (batch_id, image, display_order, is_active) VALUES (?, ?, ?, 1)");
                        $stmt->execute([$batch_id, $image_path, $nextOrder]);
                    }
                }
            }
        }

        if (empty($error) && !empty($batch_id)) {
            $msg = ($action === 'add') ? "Batch created successfully." : "Batch updated successfully.";
            header("Location: manage-sliders?tab=" . $batch_id . "&success=" . urlencode($msg));
            exit;
        }
    }
}

// Fetch all batches with total slider count in a single query (explicit columns)
$batchesStmt = $pdo->query("
    SELECT b.id, b.batch_name, b.is_active, b.is_forced, COUNT(s.id) AS slider_count
    FROM slider_batches b
    LEFT JOIN hero_sliders s ON s.batch_id = b.id
    GROUP BY b.id
    ORDER BY b.id ASC
");
$batches = $batchesStmt->fetchAll();

// Determine Active Tab
$activeBatchId = isset($_GET['tab']) ? (int)$_GET['tab'] : ($batches[0]['id'] ?? 0);
$activeBatch = null;
foreach ($batches as $b) {
    if ($b['id'] == $activeBatchId) {
        $activeBatch = $b;
        break;
    }
}
if (!$activeBatch && !empty($batches)) {
    $activeBatch = $batches[0];
    $activeBatchId = $activeBatch['id'];
}

// Calculate Currently Live Homepage Batch (Forced or Monthly Rotation)
$liveBatchId = null;
$forcedBatch = null;
foreach ($batches as $b) {
    if (!empty($b['is_forced'])) {
        $forcedBatch = $b;
        break;
    }
}

if ($forcedBatch) {
    $liveBatchId = $forcedBatch['id'];
} else {
    $activeBatchesList = array_values(array_filter($batches, function($b) { return !empty($b['is_active']); }));
    $totalActiveBatches = count($activeBatchesList);
    if ($totalActiveBatches > 0) {
        $currentMonth = (int)date('n'); // 1-12
        $batchIndex = ($currentMonth - 1) % $totalActiveBatches;
        $liveBatchId = $activeBatchesList[$batchIndex]['id'];
    }
}

// Fetch sliders ONLY for the active batch (explicit required columns)
if ($activeBatch) {
    $stmt = $pdo->prepare("SELECT id, batch_id, image, display_order, is_active FROM hero_sliders WHERE batch_id = ? ORDER BY display_order ASC, id ASC");
    $stmt->execute([$activeBatch['id']]);
    $activeBatch['sliders'] = $stmt->fetchAll();
}

$pageTitle = 'Manage Home Sliders';
include 'includes/header.php'; 
?>
<!-- Include SortableJS for smooth drag-and-drop reordering (deferred non-blocking load) -->
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js" defer></script>

<?php include 'includes/sidebar.php'; ?>

<div class="flex-1 flex flex-col min-w-0 bg-[#F8F9FA] relative z-10 font-inter">
    <?php include 'includes/topbar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-extrabold font-montserrat text-slate-800 tracking-tight">Manage Home Sliders</h2>
                <p class="text-[13px] text-slate-500 mt-1 font-inter">Organize homepage hero carousel photos into seasonal or campaign collections.</p>
            </div>
            <div class="flex flex-wrap gap-2.5">
                <button onclick="openBatchModal('add')" class="bg-gradient-to-r from-secondary to-[#721c1c] text-white px-5 py-2.5 rounded-lg text-[13px] font-bold hover:shadow-lg hover:brightness-110 active:scale-[0.98] transition-all flex items-center shadow-sm self-start sm:self-auto gap-1.5">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" /></svg>
                    Create Collection
                </button>
            </div>
        </div>

        <!-- Segmented Tab Navigation Bar -->
        <?php if (!empty($batches)): ?>
            <div class="bg-slate-200/60 backdrop-blur-md p-1.5 rounded-2xl border border-slate-300/40 shadow-inner flex items-center gap-1.5 overflow-x-auto custom-scrollbar mb-6">
                <?php foreach ($batches as $index => $b): ?>
                    <?php 
                        $isActiveTab = ($b['id'] == $activeBatchId); 
                        $isLiveHomepage = ($b['id'] == $liveBatchId);
                        $tabClasses = $isActiveTab ? 'bg-primary text-white shadow-md font-bold' : 'bg-white/60 text-slate-600 hover:text-slate-900 hover:bg-white border border-slate-200/60 font-semibold';
                    ?>
                    <a href="?tab=<?= $b['id'] ?>" class="flex items-center gap-2 px-5 py-2.5 rounded-xl text-xs whitespace-nowrap transition-all duration-200 <?= $tabClasses ?>">
                        <span><?= htmlspecialchars($b['batch_name']) ?></span>
                        <span class="px-2 py-0.5 rounded-full text-[10px] <?= $isActiveTab ? 'bg-white/20 text-white font-extrabold' : 'bg-slate-100 text-slate-500' ?>"><?= (int)$b['slider_count'] ?></span>
                        <?php if ($isLiveHomepage): ?>
                            <span class="bg-emerald-500 text-white text-[10px] font-extrabold px-2 py-0.5 rounded-full flex items-center gap-1 shadow-xs" title="Currently live on homepage (Rotates monthly)">
                                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span> Live
                            </span>
                        <?php endif; ?>
                        <?php if ($b['is_forced'] && !$isLiveHomepage): ?>
                            <span class="w-2 h-2 rounded-full bg-amber-300 animate-pulse" title="Pinned to Homepage"></span>
                        <?php endif; ?>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <!-- Active Batch Content View -->
        <?php if (empty($batches)): ?>
            <div class="bg-white rounded-2xl p-12 text-center border border-slate-200/80 shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mx-auto mb-4 font-bold">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"></path></svg>
                </div>
                <h3 class="text-base font-bold text-slate-800">No Slider Batches Configured</h3>
                <p class="text-xs text-slate-500 mt-1 mb-5">Create your first batch to start uploading hero carousel images.</p>
                <button onclick="openBatchModal('add')" class="bg-primary text-white px-5 py-2.5 rounded-xl text-xs font-bold hover:bg-primary/90 transition-all">Create First Batch</button>
            </div>
        <?php elseif ($activeBatch): ?>
            <div class="bg-white border <?= $activeBatch['is_forced'] ? 'border-amber-400 ring-2 ring-amber-400/20' : 'border-slate-200/80' ?> rounded-2xl p-6 shadow-sm relative transition-all">
                <!-- Tab Header Bar -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-5 border-b border-slate-100 mb-6">
                    <div>
                        <div class="flex items-center gap-2.5 flex-wrap">
                            <h3 class="text-xl font-extrabold text-slate-800 font-montserrat"><?= htmlspecialchars($activeBatch['batch_name']) ?></h3>
                            <button onclick="openBatchModal('edit', <?= htmlspecialchars(json_encode($activeBatch)) ?>)" class="text-slate-400 hover:text-slate-600 p-1 rounded transition-colors" title="Edit Collection Name">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125"></path></svg>
                            </button>
                            <?php if ($activeBatch['id'] == $liveBatchId): ?>
                                <span class="bg-emerald-100 text-emerald-800 border border-emerald-300 px-3 py-1 rounded-full text-xs font-bold flex items-center gap-1.5">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    NOW SHOWING ON HOMEPAGE <span class="text-[11px] font-medium text-emerald-700 font-inter">(Rotates automatically every month)</span>
                                </span>
                            <?php endif; ?>
                            <?php if ($activeBatch['is_forced']): ?>
                                <span class="bg-amber-100 text-amber-800 border border-amber-300 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">PINNED TO HOMEPAGE</span>
                            <?php endif; ?>
                            <?php if (!$activeBatch['is_active']): ?>
                                <span class="bg-slate-100 text-slate-500 px-2.5 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider">EXCLUDED FROM ROTATION</span>
                            <?php endif; ?>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Contains <?= count($activeBatch['sliders']) ?> photo(s) &bull; <span class="text-slate-500 font-medium">Drag cards to change photo order</span></p>
                    </div>

                    <!-- Quick Batch Control Actions -->
                    <div class="flex items-center gap-2 flex-wrap">
                        <?php $forceClasses = $activeBatch['is_forced'] ? 'bg-amber-500 hover:bg-amber-600 text-white' : 'bg-slate-100 hover:bg-slate-200 text-slate-700'; ?>
                        <a href="?force_batch=<?= $activeBatch['id'] ?>&csrf_token=<?= generateCsrfToken() ?>&tab=<?= $activeBatch['id'] ?>" 
                           class="<?= $forceClasses ?> px-3.5 py-2 rounded-xl text-xs font-bold transition-all shadow-sm flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"></path></svg>
                            <?= $activeBatch['is_forced'] ? 'Unpin Collection' : 'Pin to Homepage' ?>
                        </a>
                        <?php $activeClasses = $activeBatch['is_active'] ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' : 'bg-slate-100 text-slate-500 border-slate-200'; ?>
                        <a href="?toggle_batch_active=<?= $activeBatch['id'] ?>&csrf_token=<?= generateCsrfToken() ?>&tab=<?= $activeBatch['id'] ?>" 
                           class="px-3.5 py-2 rounded-xl text-xs font-bold border transition-all shadow-sm <?= $activeClasses ?>">
                            <?= $activeBatch['is_active'] ? 'Included in Rotation' : 'Excluded' ?>
                        </a>
                        <button type="button" data-delete-url="?delete_batch=<?= (int)$activeBatch['id'] ?>&csrf_token=<?= generateCsrfToken() ?>" onclick="promptDeleteBatch(this)" class="p-2 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-xl transition-colors" title="Delete Collection">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                        </button>
                    </div>
                </div>

                <!-- Direct Interactive Drag & Drop File Upload Zone -->
                <div id="dropzone" class="border-2 border-dashed border-slate-300 hover:border-primary bg-gradient-to-br from-slate-50/80 via-white to-primary/5 hover:shadow-lg rounded-2xl p-8 text-center cursor-pointer transition-all duration-300 mb-8 relative group overflow-hidden">
                    <input type="file" id="dropzoneInput" multiple accept="image/jpeg,image/png,image/webp" class="hidden">
                    <div class="flex flex-col items-center justify-center pointer-events-none relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-primary/10 text-primary flex items-center justify-center mb-3.5 group-hover:scale-110 group-hover:bg-primary group-hover:text-white transition-all duration-300 shadow-xs">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 16.5V9.75m0 0l3 3m-3-3l-3 3M6.75 19.5a4.5 4.5 0 01-1.41-8.775 5.25 5.25 0 0110.233-2.33 3 3 0 013.758 3.848A3.752 3.752 0 0118 19.5H6.75z"></path></svg>
                        </div>
                        <p class="text-sm font-extrabold text-slate-800">Drag & drop photos here, or <span class="text-primary underline decoration-primary/40 underline-offset-4">click to browse</span></p>
                        <p class="text-[11.5px] text-slate-400 mt-1 font-medium">Add photos directly into <span class="font-bold text-slate-700"><?= htmlspecialchars($activeBatch['batch_name']) ?></span> (JPG, PNG or WEBP up to 5MB)</p>
                    </div>
                </div>

                <!-- Slider Photos Card Grid -->
                <div class="slider-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6" id="sliderGrid" data-batch-id="<?= (int)$activeBatch['id'] ?>">
                    <?php foreach (($activeBatch['sliders'] ?? []) as $s): ?>
                        <?php 
                        $slide_path = $s['image'];
                        $display_img = (strpos($slide_path, 'uploads/') === 0) ? $slide_path : '../' . $slide_path;
                        ?>
                        <div class="slider-card bg-white border border-slate-200/80 rounded-2xl overflow-hidden group hover:shadow-[0_12px_24px_-8px_rgba(0,0,0,0.12)] hover:-translate-y-1 transition-all duration-300 flex flex-col select-none relative" 
                             data-slider-id="<?= (int)$s['id'] ?>">
                            <div class="relative h-52 w-full bg-slate-950 overflow-hidden cursor-pointer group/img" onclick="openImagePreview('<?= htmlspecialchars($display_img) ?>', '<?= htmlspecialchars(basename($s['image'])) ?>', <?= (int)$s['display_order'] ?>)">
                                <img src="<?= htmlspecialchars($display_img) ?>" alt="Slider" loading="lazy" decoding="async" class="w-full h-full object-cover object-center group-hover/img:scale-105 transition-transform duration-500 pointer-events-none">
                                
                                <!-- Hover Zoom Preview Overlay -->
                                <div class="absolute inset-0 bg-slate-950/40 opacity-0 group-hover/img:opacity-100 transition-opacity duration-300 flex items-center justify-center pointer-events-none z-10">
                                    <div class="bg-white/25 backdrop-blur-md p-3 rounded-full text-white border border-white/40 shadow-xl transform scale-90 group-hover/img:scale-100 transition-transform duration-300">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.573 16.49 16.638 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"></path><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                </div>

                                <div class="order-badge absolute top-3 left-3 bg-black/60 backdrop-blur-md text-white text-[10px] font-bold px-2.5 py-1 rounded-lg shadow-sm z-20">
                                    Order: <?= (int)$s['display_order'] ?>
                                </div>

                                <!-- SortableJS Drag Handle -->
                                <div class="drag-handle absolute top-3 right-3 bg-black/60 backdrop-blur-md text-white p-2 rounded-xl shadow-sm cursor-grab active:cursor-grabbing opacity-80 hover:opacity-100 hover:bg-black/90 transition-all z-20" onclick="event.stopPropagation()" title="Drag to reorder">
                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path></svg>
                                </div>

                                <?php if (!$s['is_active']): ?>
                                    <div class="status-overlay absolute inset-0 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center z-10 pointer-events-none">
                                        <span class="bg-rose-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-sm">Disabled</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- Instant Photo Action Footer -->
                            <div class="p-4 flex items-center justify-between bg-white border-t border-slate-100 mt-auto">
                                <span class="text-[11px] text-slate-400 font-mono truncate max-w-[150px]" title="<?= htmlspecialchars(basename($s['image'])) ?>"><?= htmlspecialchars(basename($s['image'])) ?></span>
                                <div class="flex items-center gap-3">
                                    <!-- Instant Status Toggle Switch -->
                                    <label class="relative inline-flex items-center cursor-pointer" title="Toggle active status">
                                        <input type="checkbox" onchange="toggleSliderStatus(<?= (int)$s['id'] ?>, this)" class="sr-only peer" <?= $s['is_active'] ? 'checked' : '' ?>>
                                        <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                    </label>

                                    <!-- 1-Click Delete Button -->
                                    <button type="button" data-delete-url="?delete_slider=<?= (int)$s['id'] ?>&csrf_token=<?= generateCsrfToken() ?>&tab=<?= (int)$activeBatch['id'] ?>" onclick="promptDeleteSlider(this)" class="p-1.5 text-rose-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors" title="Delete Photo">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </main>
</div>

<!-- Add / Edit Batch Modal -->
<div id="batchModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeBatchModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden transform scale-95 transition-all duration-300 relative z-10 border border-slate-100 my-auto">
        <div class="flex justify-between items-center p-6 border-b border-slate-100 bg-slate-50/50">
            <h3 class="text-lg font-bold font-montserrat text-slate-800" id="batchModalTitle">Create New Collection</h3>
            <button type="button" onclick="closeBatchModal()" class="text-slate-400 hover:text-slate-600 p-1.5 rounded-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="" method="POST" enctype="multipart/form-data" class="p-6 space-y-5">
            <input type="hidden" name="csrf_token" value="<?= generateCsrfToken() ?>">
            <input type="hidden" name="form_type" value="batch">
            <input type="hidden" name="action" id="batchAction" value="add">
            <input type="hidden" name="batch_id" id="batchId" value="">

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Collection Name <span class="text-red-500">*</span></label>
                <input type="text" name="batch_name" id="batchNameInput" required placeholder="e.g. National Day Collection" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-sm font-semibold">
            </div>

            <div>
                <label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">Upload Photos (Optional / Multiple)</label>
                <input type="file" name="batch_images[]" multiple accept="image/jpeg,image/png,image/webp" class="w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-1">Select one or multiple images to add to this collection immediately.</p>
            </div>

            <label class="flex items-center gap-3 cursor-pointer">
                <input type="checkbox" name="is_active" id="batchActiveInput" value="1" checked class="w-4 h-4 text-primary rounded focus:ring-primary">
                <span class="text-xs font-semibold text-slate-700">Include in monthly homepage rotation</span>
            </label>

            <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                <button type="button" onclick="closeBatchModal()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200">Cancel</button>
                <button type="submit" class="px-6 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-700">Save Collection</button>
            </div>
        </form>
    </div>
</div>

<!-- Custom Confirmation Modal -->
<div id="confirmModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <div class="absolute inset-0 bg-[#0F172A]/40 backdrop-blur-sm" onclick="closeConfirmModal()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden transform scale-95 transition-all duration-300 relative z-10 border border-slate-100 p-6 text-center my-auto">
        <div class="w-12 h-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mx-auto mb-4 font-bold">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"></path></svg>
        </div>
        <h3 class="text-base font-bold text-slate-800 font-montserrat" id="confirmModalTitle">Confirm Action</h3>
        <p class="text-xs text-slate-500 mt-1 mb-6 font-inter" id="confirmModalMessage">Are you sure you want to proceed?</p>
        <div class="flex justify-center gap-3">
            <button type="button" onclick="closeConfirmModal()" class="px-4 py-2 bg-slate-100 text-slate-600 rounded-xl text-xs font-bold hover:bg-slate-200 transition-all">Cancel</button>
            <a id="confirmModalTarget" href="#" class="px-5 py-2 bg-rose-600 text-white rounded-xl text-xs font-bold hover:bg-rose-700 transition-all shadow-sm">Confirm Delete</a>
        </div>
    </div>
</div>

<!-- Image Preview Modal (Matching Officials Page Experience) -->
<div id="imagePreviewModal" class="fixed inset-0 z-[150] hidden items-center justify-center p-4 transition-all duration-300 opacity-0">
    <div class="absolute inset-0 bg-[#0F172A]/70 backdrop-blur-sm" onclick="closeImagePreview()"></div>
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl overflow-hidden transform scale-95 transition-all duration-300 relative z-10 border border-slate-100 flex flex-col my-auto max-h-[90vh]">
        <div class="flex justify-between items-center px-6 py-4 border-b border-slate-100 bg-slate-50/50">
            <div>
                <h3 class="text-base font-bold font-montserrat text-slate-800">Slider Photo Preview</h3>
                <p class="text-xs text-slate-400 font-mono" id="previewModalFilename"></p>
            </div>
            <button type="button" onclick="closeImagePreview()" class="text-slate-400 hover:text-slate-600 hover:bg-slate-100 p-1.5 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-6 overflow-y-auto flex items-center justify-center bg-slate-950 flex-1 min-h-[350px]">
            <img id="previewModalImg" src="" alt="Full Preview" class="max-h-[65vh] max-w-full object-contain rounded-xl shadow-2xl">
        </div>
        <div class="p-4 border-t border-slate-100 bg-white flex items-center justify-between">
            <span class="text-xs font-bold text-slate-500 font-mono" id="previewModalOrder"></span>
            <button type="button" onclick="closeImagePreview()" class="px-5 py-2 bg-slate-800 text-white rounded-xl text-xs font-bold hover:bg-slate-700 transition-all shadow-sm">Close Preview</button>
        </div>
    </div>
</div>

<script>
const CSRF_TOKEN = <?= json_encode(generateCsrfToken()) ?>;
const ACTIVE_BATCH_ID = <?= json_encode($activeBatchId) ?>;

// Custom Confirm Modal Handler
function promptConfirm(targetUrl, title, message) {
    const modal = document.getElementById('confirmModal');
    document.getElementById('confirmModalTitle').textContent = title;
    document.getElementById('confirmModalMessage').textContent = message;
    document.getElementById('confirmModalTarget').href = targetUrl;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => { modal.classList.remove('opacity-0'); modal.children[1].classList.remove('scale-95'); }, 10);
}

function promptDeleteBatch(btn) {
    if (btn && btn.dataset.deleteUrl) {
        promptConfirm(btn.dataset.deleteUrl, 'Delete Photo Collection', 'Are you sure you want to delete this collection and all its photos?');
    }
}

function promptDeleteSlider(btn) {
    if (btn && btn.dataset.deleteUrl) {
        promptConfirm(btn.dataset.deleteUrl, 'Delete Photo', 'Are you sure you want to delete this photo?');
    }
}

function closeConfirmModal() {
    const modal = document.getElementById('confirmModal');
    modal.classList.add('opacity-0');
    modal.children[1].classList.add('scale-95');
    setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 300);
}

// Full Image Preview Modal Logic
function openImagePreview(src, filename, order) {
    document.getElementById('previewModalImg').src = src;
    document.getElementById('previewModalFilename').textContent = filename;
    document.getElementById('previewModalOrder').textContent = `Display Order: ${order}`;
    
    const modal = document.getElementById('imagePreviewModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => { modal.classList.remove('opacity-0'); modal.children[1].classList.remove('scale-95'); }, 10);
}

function closeImagePreview() {
    const modal = document.getElementById('imagePreviewModal');
    modal.classList.add('opacity-0');
    modal.children[1].classList.add('scale-95');
    setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 300);
}

// Centered Modal Functions
function openBatchModal(action, data = null) {
    const modal = document.getElementById('batchModal');
    document.getElementById('batchAction').value = action;
    document.getElementById('batchModalTitle').textContent = action === 'edit' ? 'Edit Collection Name' : 'Create New Collection';
    
    if (action === 'edit' && data) {
        document.getElementById('batchId').value = data.id;
        document.getElementById('batchNameInput').value = data.batch_name;
        document.getElementById('batchActiveInput').checked = data.is_active == 1;
    } else {
        document.getElementById('batchId').value = '';
        document.getElementById('batchNameInput').value = '';
        document.getElementById('batchActiveInput').checked = true;
    }
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    setTimeout(() => { modal.classList.remove('opacity-0'); modal.children[1].classList.remove('scale-95'); }, 10);
}

function closeBatchModal() {
    const modal = document.getElementById('batchModal');
    modal.classList.add('opacity-0');
    modal.children[1].classList.add('scale-95');
    setTimeout(() => { modal.classList.remove('flex'); modal.classList.add('hidden'); }, 300);
}

// Instant Slider Active Toggle
async function toggleSliderStatus(sliderId, checkbox) {
    const formData = new FormData();
    formData.append('action', 'toggle_slider_status');
    formData.append('csrf_token', CSRF_TOKEN);
    formData.append('slider_id', sliderId);

    try {
        const res = await fetch(window.location.href, { method: 'POST', body: formData });
        const data = await res.json();
        if (data.success) {
            const card = checkbox.closest('.slider-card');
            const imgBox = card.querySelector('.relative');
            let overlay = imgBox.querySelector('.status-overlay');
            if (data.is_active) {
                if (overlay) overlay.remove();
            } else {
                if (!overlay) {
                    overlay = document.createElement('div');
                    overlay.className = 'status-overlay absolute inset-0 bg-slate-950/70 backdrop-blur-xs flex items-center justify-center';
                    overlay.innerHTML = '<span class="bg-rose-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">Disabled</span>';
                    imgBox.appendChild(overlay);
                }
            }
        } else {
            checkbox.checked = !checkbox.checked;
            if (typeof window.showToast === 'function') {
                window.showToast(data.message || 'Failed to toggle status', 'error');
            }
        }
    } catch (err) {
        checkbox.checked = !checkbox.checked;
        if (typeof window.showToast === 'function') {
            window.showToast('Network error while toggling status', 'error');
        }
    }
}

// Interactive Dropzone File Upload
document.addEventListener('DOMContentLoaded', () => {
    const dropzone = document.getElementById('dropzone');
    const fileInput = document.getElementById('dropzoneInput');

    if (dropzone && fileInput && ACTIVE_BATCH_ID) {
        dropzone.addEventListener('click', () => fileInput.click());

        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-primary', 'bg-primary/10');
        });

        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-primary', 'bg-primary/10');
        });

        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-primary', 'bg-primary/10');
            if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
                handleFilesUpload(e.dataTransfer.files);
            }
        });

        fileInput.addEventListener('change', () => {
            if (fileInput.files && fileInput.files.length > 0) {
                handleFilesUpload(fileInput.files);
            }
        });
    }

    async function handleFilesUpload(files) {
        if (!files || files.length === 0) return;

        dropzone.classList.add('opacity-50', 'pointer-events-none');
        let successCount = 0;
        let errorMessages = [];

        // Upload files ONE BY ONE to prevent exceeding PHP post_max_size (8M) when selecting multiple files
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // Client-side file size check (10MB limit per file)
            if (file.size > 10 * 1024 * 1024) {
                errorMessages.push(`'${file.name}' is too large (max 10MB).`);
                continue;
            }

            const formData = new FormData();
            formData.append('action', 'upload_dropzone_images');
            formData.append('csrf_token', CSRF_TOKEN);
            formData.append('batch_id', ACTIVE_BATCH_ID);
            formData.append('images[]', file);

            try {
                const res = await fetch(window.location.href, { method: 'POST', body: formData });
                if (!res.ok) {
                    errorMessages.push(`'${file.name}': Server error ${res.status}`);
                    continue;
                }
                const data = await res.json();

                if (data.success && data.uploaded && data.uploaded.length > 0) {
                    successCount++;
                } else {
                    errorMessages.push(`'${file.name}': ${data.message || 'Upload failed'}`);
                }
            } catch (err) {
                errorMessages.push(`'${file.name}': Network error`);
            }
        }

        dropzone.classList.remove('opacity-50', 'pointer-events-none');

        if (successCount > 0) {
            window.location.reload();
        } else if (errorMessages.length > 0) {
            if (typeof window.showToast === 'function') {
                window.showToast(errorMessages.join(' | '), 'error');
            }
        }
    }

    // SortableJS Drag and Drop Reordering
    const grid = document.getElementById('sliderGrid');
    if (grid && typeof Sortable !== 'undefined') {
        new Sortable(grid, {
            handle: '.drag-handle',
            animation: 150,
            ghostClass: 'opacity-40',
            onEnd: async function (evt) {
                const cards = Array.from(grid.querySelectorAll('.slider-card'));
                const sliderIds = cards.map(c => c.dataset.sliderId);

                // Live update visible order badges
                cards.forEach((card, index) => {
                    const badge = card.querySelector('.order-badge');
                    if (badge) badge.textContent = `Order: ${index + 1}`;
                });

                if (sliderIds.length > 0) {
                    const formData = new FormData();
                    formData.append('action', 'reorder_sliders');
                    formData.append('csrf_token', CSRF_TOKEN);
                    sliderIds.forEach(id => formData.append('slider_ids[]', id));

                    try {
                        const res = await fetch(window.location.href, { method: 'POST', body: formData });
                        const data = await res.json();
                        if (data.success) {
                            if (typeof window.showToast === 'function') {
                                window.showToast('Slider display order updated!', 'success');
                            }
                        }
                    } catch (err) {
                        if (typeof window.showToast === 'function') {
                            window.showToast('Failed to save order.', 'error');
                        }
                    }
                }
            }
        });
    }

    // Bulk Action Selection & Handlers
    const selectAllCb = document.getElementById('selectAllSliders');
    const itemCbs = document.querySelectorAll('.slider-select-cb');
    const bulkPanel = document.getElementById('bulkActionsPanel');

    function updateBulkPanelState() {
        const anyChecked = Array.from(itemCbs).some(cb => cb.checked);
        if (bulkPanel) {
            if (anyChecked) {
                bulkPanel.classList.remove('opacity-50', 'pointer-events-none');
            } else {
                bulkPanel.classList.add('opacity-50', 'pointer-events-none');
            }
        }
    }

    if (selectAllCb) {
        selectAllCb.addEventListener('change', (e) => {
            itemCbs.forEach(cb => cb.checked = e.target.checked);
            updateBulkPanelState();
        });
    }

    itemCbs.forEach(cb => {
        cb.addEventListener('change', () => {
            const allChecked = Array.from(itemCbs).length > 0 && Array.from(itemCbs).every(c => c.checked);
            if (selectAllCb) selectAllCb.checked = allChecked;
            updateBulkPanelState();
        });
    });

    window.promptBulkDelete = function() {
        const selectedIds = Array.from(itemCbs).filter(cb => cb.checked).map(cb => cb.value);
        if (selectedIds.length === 0) return;
        promptConfirm('javascript:performBulkAction("delete")', 'Delete Selected Photos', `Are you sure you want to delete ${selectedIds.length} selected photo(s)?`);
    };

    window.performBulkAction = async function(actionType) {
        if (actionType === 'delete') closeConfirmModal();
        
        const selectedIds = Array.from(itemCbs).filter(cb => cb.checked).map(cb => cb.value);
        if (selectedIds.length === 0) return;

        const formData = new FormData();
        formData.append('action', 'bulk_action');
        formData.append('csrf_token', CSRF_TOKEN);
        formData.append('bulk_type', actionType);
        selectedIds.forEach(id => formData.append('slider_ids[]', id));

        try {
            const res = await fetch(window.location.href, { method: 'POST', body: formData });
            const data = await res.json();
            if (data.success) {
                window.location.reload();
            } else {
                if (typeof window.showToast === 'function') window.showToast(data.message || 'Action failed', 'error');
            }
        } catch (err) {
            if (typeof window.showToast === 'function') window.showToast('Network error during bulk action.', 'error');
        }
    };
});
</script>

<?php include 'includes/footer.php'; ?>
