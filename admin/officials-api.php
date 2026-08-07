<?php
// admin/officials-api.php
require_once 'includes/auth.php'; // Updated to use auth.php
require_once 'includes/db.php';
require_once 'includes/functions.php';
require_once '../includes/officials-service.php';

header('Content-Type: application/json');

// Login and Role validation
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
    exit;
}

// Only super_admin and admin allowed (if editor has role = 'editor', reject)
if (!hasPermission("manage_officials")) {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

// Detect empty POST payload caused by PHP post_max_size limit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && empty($_POST) && isset($_SERVER['CONTENT_LENGTH']) && $_SERVER['CONTENT_LENGTH'] > 0) {
    echo json_encode(['success' => false, 'message' => 'Uploaded request exceeds PHP server post_max_size limit. Please choose a smaller image.']);
    exit;
}

// CSRF validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !verifyCsrfToken($_POST['csrf_token'])) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token or session expired.']);
        exit;
    }
}

$action = !empty($_POST['action']) ? $_POST['action'] : ($_REQUEST['action'] ?? '');

try {
    switch ($action) {
        case 'save_official':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $remove_image = isset($_POST['remove_image']) && $_POST['remove_image'] === '1';

            $data = [
                'category' => $_POST['category'] ?? 'division',
                'top_role' => !empty($_POST['top_role']) ? $_POST['top_role'] : null,
                'division_id' => !empty($_POST['division_id']) ? (int)$_POST['division_id'] : null,
                'title' => $_POST['title'] ?? '',
                'title_si' => $_POST['title_si'] ?? '',
                'title_ta' => $_POST['title_ta'] ?? '',
                'name' => $_POST['name'] ?? '',
                'name_si' => $_POST['name_si'] ?? '',
                'name_ta' => $_POST['name_ta'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'fax' => $_POST['fax'] ?? '',
                'remove_image' => $remove_image
            ];

            $existingImage = null;
            if ($id) {
                $stmt = $pdo->prepare("SELECT image_path FROM officials WHERE id = ?");
                $stmt->execute([$id]);
                $existingImage = $stmt->fetchColumn();
                $data['image_path'] = $existingImage;
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadResult = handleFileUpload($_FILES['image'], 'uploads/officials', ['image/jpeg', 'image/png', 'image/webp'], 5242880);
                if (!$uploadResult['success']) {
                    throw new Exception($uploadResult['error'] ?? 'Image upload failed.');
                }

                if (!empty($existingImage) && file_exists(__DIR__ . '/../' . $existingImage)) {
                    if (strpos($existingImage, 'admin/uploads/officials/') === 0 || strpos($existingImage, 'uploads/officials/') === 0) {
                        @unlink(__DIR__ . '/../' . $existingImage);
                    }
                }
                $data['image_path'] = $uploadResult['path'];
                $data['remove_image'] = false; // New image upload overrides remove flag
            } elseif ($remove_image && $id && !empty($existingImage)) {
                if (file_exists(__DIR__ . '/../' . $existingImage)) {
                    if (strpos($existingImage, 'admin/uploads/officials/') === 0 || strpos($existingImage, 'uploads/officials/') === 0) {
                        @unlink(__DIR__ . '/../' . $existingImage);
                    }
                }
                $data['image_path'] = null;
            }

            $newId = saveOfficial($pdo, $data, $id);
            echo json_encode(['success' => true, 'message' => 'Official saved successfully.', 'id' => $newId]);
            break;

        case 'delete_official':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : 0;
            if (!$id) {
                throw new Exception('Invalid ID');
            }
            // Additional check: Don't allow deleting top officials
            $stmt = $pdo->prepare("SELECT category FROM officials WHERE id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() === 'top') {
                throw new Exception('Cannot delete Top Officials.');
            }
            
            deleteOfficial($pdo, $id);
            echo json_encode(['success' => true, 'message' => 'Official deleted successfully.']);
            break;

        case 'update_sort_order':
            $order = isset($_POST['order']) ? json_decode($_POST['order'], true) : [];
            if (empty($order) || !is_array($order)) {
                throw new Exception('Invalid order data.');
            }
            updateSortOrder($pdo, $order);
            echo json_encode(['success' => true, 'message' => 'Order updated successfully.']);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}

