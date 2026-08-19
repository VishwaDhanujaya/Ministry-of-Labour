<?php
require_once 'includes/auth.php';

if (!isLoggedIn()) {
    header('Content-Type: application/json');
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'unauthorized']);
    exit;
}

$_SESSION['is_locked'] = true;
$_SESSION['locked_page'] = $_POST['current_url'] ?? '';

header('Content-Type: application/json');
echo json_encode(['success' => true]);
exit;
