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

// Auto-migrate legacy or corrupted sessions to executive_officer
if (isset($_SESSION['admin_role']) && in_array($_SESSION['admin_role'], ['super_admin', 'admin', ''])) {
    $_SESSION['admin_role'] = 'executive_officer';
}

// Inactivity check (10 minutes = 600 seconds)
if (isset($_SESSION['admin_id'])) {
    if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 600)) {
        session_unset();
        session_destroy();
        $current_script = basename($_SERVER['SCRIPT_NAME']);
        if ($current_script !== 'login.php' && $current_script !== 'logout.php') {
            header("Location: login.php?timeout=1");
            exit;
        }
    }
    $_SESSION['last_activity'] = time();
}

// Centralized Role Capabilities Mapping
$role_capabilities = [
    'executive_officer' => [
        'manage_users', 'approve_news', 'manage_news', 'manage_bookings',
        'manage_iau', 'manage_learning', 'manage_procurements',
        'manage_notices', 'manage_statistics', 'manage_vacancies',
        'manage_officials', 'manage_settings'
    ],
    'content_editor' => [
        'manage_news'
    ]
];

function hasPermission($capability) {
    if (!isLoggedIn()) return false;
    global $role_capabilities;
    $role = $_SESSION['admin_role'] ?? '';
    if (!isset($role_capabilities[$role])) {
        return false;
    }
    return in_array($capability, $role_capabilities[$role]);
}

function requirePermission($capability) {
    if (!hasPermission($capability)) {
        header("Location: index.php?error=forbidden");
        exit;
    }
}

// Backward-compatible alias
function isSuperAdmin() {
    return hasPermission('manage_users');
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
    $_SESSION['last_activity'] = time();
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
