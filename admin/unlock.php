<?php
require_once 'includes/auth.php';
require_once 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: dashboard");
    exit;
}

$csrf_token = $_POST['csrf_token'] ?? '';
if (!verifyCsrfToken($csrf_token)) {
    header("HTTP/1.1 403 Forbidden");
    echo "CSRF token verification failed.";
    exit;
}

$password = $_POST['password'] ?? '';
$redirect_to = trim($_POST['redirect_to'] ?? '');

// Sanitize redirect_to to prevent open redirect vulnerabilities
if (empty($redirect_to) || strpos($redirect_to, '//') === 0 || preg_match('/^https?:\/\//i', $redirect_to)) {
    $redirect_to = 'dashboard';
}

$admin_id = $_SESSION['admin_id'] ?? null;

if (!$admin_id) {
    header("Location: login");
    exit;
}

// Fetch the admin's password hash from database
$stmt = $pdo->prepare("SELECT password_hash FROM admins WHERE id = :id");
$stmt->execute(['id' => $admin_id]);
$admin = $stmt->fetch();

$is_ajax = (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') || isset($_POST['ajax']);

if ($admin && password_verify($password, $admin['password_hash'])) {
    // Unlock successful
    $_SESSION['is_locked'] = false;
    $_SESSION['failed_unlock_attempts'] = 0;
    $_SESSION['last_activity'] = time();
    
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
        exit;
    }
    
    header("Location: " . $redirect_to);
    exit;
} else {
    // Unlock failed
    if (!isset($_SESSION['failed_unlock_attempts'])) {
        $_SESSION['failed_unlock_attempts'] = 0;
    }
    $_SESSION['failed_unlock_attempts']++;
    
    if ($_SESSION['failed_unlock_attempts'] >= 3) {
        // Destroy session on 3 failed attempts
        logoutAdmin();
        
        if ($is_ajax) {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'error' => 'too_many_attempts',
                'redirect' => $base_url . 'admin/login.php?timeout=2'
            ]);
            exit;
        }
        
        header("Location: login.php?timeout=2"); // custom timeout code for too many failures
        exit;
    }
    
    $remaining = 3 - $_SESSION['failed_unlock_attempts'];
    if ($is_ajax) {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'error' => 'invalid_password',
            'message' => 'Incorrect password. ' . $remaining . ' ' . ($remaining === 1 ? 'attempt' : 'attempts') . ' remaining.',
            'remaining' => $remaining
        ]);
        exit;
    }
    
    // Redirect back to show the lock screen error
    // Ensure we preserve the unlock_error flag in the query string
    $separator = (strpos($redirect_to, '?') === false) ? '?' : '&';
    header("Location: " . $redirect_to . $separator . "unlock_error=1");
    exit;
}
