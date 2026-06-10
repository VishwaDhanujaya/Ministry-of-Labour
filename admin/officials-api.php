<?php
// admin/officials-api.php
require_once 'includes/auth.php'; // Updated to use auth.php
require_once 'includes/db.php';
require_once '../includes/officials-service.php';

header('Content-Type: application/json');

// CSRF validation
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }
}

// Only super_admin and admin allowed (if editor has role = 'editor', reject)
if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'editor') {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
    exit;
}

$action = $_POST['action'] ?? '';

try {
    switch ($action) {
        case 'save_official':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
            $data = [
                'category' => $_POST['category'] ?? 'division',
                'top_role' => !empty($_POST['top_role']) ? $_POST['top_role'] : null,
                'division_id' => !empty($_POST['division_id']) ? (int)$_POST['division_id'] : null,
                'title' => $_POST['title'] ?? '',
                'name' => $_POST['name'] ?? '',
                'designation' => $_POST['designation'] ?? '',
                'email' => $_POST['email'] ?? '',
                'phone' => $_POST['phone'] ?? '',
                'fax' => $_POST['fax'] ?? '',
            ];

            if ($id) {
                $stmt = $pdo->prepare("SELECT image_path FROM officials WHERE id = ?");
                $stmt->execute([$id]);
                $data['image_path'] = $stmt->fetchColumn();
            }

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/officials/';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
                $allowedMimes = ['image/jpeg', 'image/png', 'image/webp'];
                
                if (!in_array($mime, $allowedMimes)) {
                    throw new Exception('Invalid file type.');
                }
                finfo_close($finfo);

                $fileExt = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $nameSlug = preg_replace('/[^a-z0-9]+/', '-', strtolower($data['name']));
                $nameSlug = trim($nameSlug, '-');
                $divPrefix = $data['category'] === 'top' ? 'top' : 'div' . $data['division_id'];
                
                $fileName = $divPrefix . '-' . $nameSlug . '-' . substr(md5(uniqid()), 0, 8) . '.' . $fileExt;
                $targetPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
                    if (!empty($data['image_path']) && strpos($data['image_path'], 'admin/uploads/officials/') === 0) {
                        @unlink(__DIR__ . '/../' . $data['image_path']);
                    }
                    $data['image_path'] = 'admin/' . $targetPath;
                } else {
                    throw new Exception('Failed to move uploaded file.');
                }
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
