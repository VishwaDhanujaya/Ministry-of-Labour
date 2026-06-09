<?php
// auth.php
// Configure secure session parameters before starting the session
session_set_cookie_params([
    'lifetime' => 86400, // 1 day
    'path' => '/',
    'secure' => isset($_SERVER['HTTPS']), // True if HTTPS
    'httponly' => true, // Prevent JavaScript access to session cookie
    'samesite' => 'Lax' // Protect against CSRF
]);
ini_set('session.use_only_cookies', 1);

session_start();

// Global Backend Security Headers
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: SAMEORIGIN");
header("X-XSS-Protection: 1; mode=block");
header("Strict-Transport-Security: max-age=31536000; includeSubDomains");

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login");
        exit;
    }
}

function isSuperAdmin() {
    if (!isLoggedIn()) return false;
    return ($_SESSION['admin_role'] ?? '') === 'super_admin';
}

function getLoggedInAdmin() {
    if (!isLoggedIn()) return null;
    return [
        'id' => $_SESSION['admin_id'] ?? null,
        'name' => $_SESSION['admin_name'] ?? null,
        'role' => $_SESSION['admin_role'] ?? null
    ];
}

function loginAdmin($id, $name, $role) {
    $_SESSION['admin_id'] = $id;
    $_SESSION['admin_name'] = $name;
    $_SESSION['admin_role'] = $role;
}

function logoutAdmin() {
    session_unset();
    session_destroy();
}

function generateCsrfToken() {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function requireCsrfToken($method = 'POST', $source = 'post') {
    if ($_SERVER['REQUEST_METHOD'] === $method) {
        $token = $source === 'get' ? ($_GET['csrf_token'] ?? '') : ($_POST['csrf_token'] ?? '');
        if (!verifyCsrfToken($token)) {
            die("CSRF Token Validation Failed. Please try again.");
        }
    }
}
?>
