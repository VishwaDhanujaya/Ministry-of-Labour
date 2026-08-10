<?php
// admin/iau-officers-api.php
require_once 'includes/auth.php';
require_once 'includes/db.php';
require_once 'includes/functions.php';

header('Content-Type: application/json');

// Login and Role validation
if (!isLoggedIn()) {
    echo json_encode(['success' => false, 'message' => 'Session expired. Please log in again.']);
    exit;
}

// Check permission
if (!hasPermission("manage_iau")) {
    echo json_encode(['success' => false, 'message' => 'Forbidden']);
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
        case 'save_officer':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;

            $title = trim($_POST['title'] ?? '');
            $title_si = trim($_POST['title_si'] ?? '');
            $title_ta = trim($_POST['title_ta'] ?? '');
            $department = trim($_POST['department'] ?? '');
            $department_si = trim($_POST['department_si'] ?? '');
            $department_ta = trim($_POST['department_ta'] ?? '');
            $name = trim($_POST['name'] ?? '');
            $name_si = trim($_POST['name_si'] ?? '');
            $name_ta = trim($_POST['name_ta'] ?? '');
            $designation = trim($_POST['designation'] ?? '');
            $designation_si = trim($_POST['designation_si'] ?? '');
            $designation_ta = trim($_POST['designation_ta'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $email = trim($_POST['email'] ?? '');

            // Mandatory fields validation: title, name, designation (with translations)
            $required = [
                'title' => 'Title',
                'title_si' => 'Title (Sinhala)',
                'title_ta' => 'Title (Tamil)',
                'name' => 'Name',
                'name_si' => 'Name (Sinhala)',
                'name_ta' => 'Name (Tamil)',
                'designation' => 'Designation',
                'designation_si' => 'Designation (Sinhala)',
                'designation_ta' => 'Designation (Tamil)'
            ];

            foreach ($required as $key => $label) {
                if (empty($$key)) {
                    echo json_encode(['success' => false, 'message' => "$label is mandatory."]);
                    exit;
                }
            }

            // If department is provided, require its translations as well
            if (!empty($department)) {
                if (empty($department_si) || empty($department_ta)) {
                    echo json_encode(['success' => false, 'message' => 'Sinhala and Tamil translations are required if Department is specified.']);
                    exit;
                }
            }

            if ($id) {
                // Update
                $stmt = $pdo->prepare("UPDATE `iau_officers` SET 
                    `title` = :title, `title_si` = :title_si, `title_ta` = :title_ta,
                    `department` = :department, `department_si` = :department_si, `department_ta` = :department_ta,
                    `name` = :name, `name_si` = :name_si, `name_ta` = :name_ta,
                    `designation` = :designation, `designation_si` = :designation_si, `designation_ta` = :designation_ta,
                    `phone` = :phone, `email` = :email 
                    WHERE `id` = :id");
                $stmt->execute([
                    ':title' => $title, ':title_si' => $title_si, ':title_ta' => $title_ta,
                    ':department' => $department, ':department_si' => $department_si, ':department_ta' => $department_ta,
                    ':name' => $name, ':name_si' => $name_si, ':name_ta' => $name_ta,
                    ':designation' => $designation, ':designation_si' => $designation_si, ':designation_ta' => $designation_ta,
                    ':phone' => $phone, ':email' => $email, ':id' => $id
                ]);
                $newId = $id;
            } else {
                // Insert
                // Get next sort order
                $sort_stmt = $pdo->query("SELECT MAX(sort_order) FROM `iau_officers`");
                $max_sort = (int)$sort_stmt->fetchColumn();
                $sort_order = $max_sort + 1;

                $stmt = $pdo->prepare("INSERT INTO `iau_officers` 
                    (`title`, `title_si`, `title_ta`, `department`, `department_si`, `department_ta`, `name`, `name_si`, `name_ta`, `designation`, `designation_si`, `designation_ta`, `phone`, `email`, `sort_order`, `is_active`) 
                    VALUES (:title, :title_si, :title_ta, :department, :department_si, :department_ta, :name, :name_si, :name_ta, :designation, :designation_si, :designation_ta, :phone, :email, :sort_order, 1)");
                $stmt->execute([
                    ':title' => $title, ':title_si' => $title_si, ':title_ta' => $title_ta,
                    ':department' => $department, ':department_si' => $department_si, ':department_ta' => $department_ta,
                    ':name' => $name, ':name_si' => $name_si, ':name_ta' => $name_ta,
                    ':designation' => $designation, ':designation_si' => $designation_si, ':designation_ta' => $designation_ta,
                    ':phone' => $phone, ':email' => $email, ':sort_order' => $sort_order
                ]);
                $newId = $pdo->lastInsertId();
            }

            echo json_encode(['success' => true, 'message' => 'IAU Officer saved successfully.', 'id' => $newId]);
            break;

        case 'delete_officer':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : 0;
            if (!$id) {
                throw new Exception('Invalid ID');
            }
            $stmt = $pdo->prepare("DELETE FROM `iau_officers` WHERE `id` = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'IAU Officer deleted successfully.']);
            break;

        case 'update_sort_order':
            $order = isset($_POST['order']) ? json_decode($_POST['order'], true) : [];
            if (empty($order) || !is_array($order)) {
                throw new Exception('Invalid order data.');
            }
            
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("UPDATE `iau_officers` SET `sort_order` = ? WHERE `id` = ?");
            foreach ($order as $index => $id) {
                $stmt->execute([$index + 1, (int)$id]);
            }
            $pdo->commit();
            
            echo json_encode(['success' => true, 'message' => 'Order updated successfully.']);
            break;

        case 'toggle_status':
            $id = !empty($_POST['id']) ? (int)$_POST['id'] : 0;
            if (!$id) {
                throw new Exception('Invalid ID');
            }
            $stmt = $pdo->prepare("UPDATE `iau_officers` SET `is_active` = 1 - `is_active` WHERE `id` = ?");
            $stmt->execute([$id]);
            echo json_encode(['success' => true, 'message' => 'Status toggled successfully.']);
            break;

        default:
            throw new Exception('Invalid action');
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
