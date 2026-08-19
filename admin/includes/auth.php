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

// Prevent local browser caching of admin pages and lock screens
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login");
        exit;
    }
}

function renderLockScreen() {
    // Check if it's an AJAX request
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
        header('Content-Type: application/json');
        http_response_code(423); // Locked
        echo json_encode(['error' => 'locked', 'message' => 'Workspace is locked.']);
        exit;
    }
    
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    $is_standalone = true;
    require_once __DIR__ . '/lockscreen-template.php';
    exit;
}

// Inactivity check (15 minutes for lock, 30 minutes for logout)
if (isset($_SESSION['admin_id'])) {
    if (isset($_SESSION['last_activity'])) {
        $inactive_time = time() - $_SESSION['last_activity'];
        if ($inactive_time > 1800) { // 30 minutes
            session_unset();
            session_destroy();
            $current_script = basename($_SERVER['SCRIPT_NAME']);
            if ($current_script !== 'login.php' && $current_script !== 'logout.php') {
                header("Location: login.php?timeout=1");
                exit;
            }
        } elseif ($inactive_time > 900) { // 15 minutes
            if (!isset($_SESSION['is_locked']) || $_SESSION['is_locked'] !== true) {
                $_SESSION['is_locked'] = true;
                // Capture the current page so we can render it blurred behind the lock screen
                $_SESSION['locked_page'] = $_SERVER['REQUEST_URI'];
            }
        }
    }
    
    // Only update last activity if the session is NOT currently locked
    if (!isset($_SESSION['is_locked']) || $_SESSION['is_locked'] !== true) {
        $_SESSION['last_activity'] = time();
    }
}

// Block write actions (POST) if session is locked
if (isset($_SESSION['admin_id']) && isset($_SESSION['is_locked']) && $_SESSION['is_locked'] === true) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $current_script = basename($_SERVER['SCRIPT_NAME']);
        if ($current_script !== 'unlock.php' && $current_script !== 'logout.php') {
            header('Content-Type: application/json');
            http_response_code(423); // Locked
            echo json_encode(['error' => 'locked', 'message' => 'Workspace is locked. Action not allowed.']);
            exit;
        }
    }
}

function hasPermission(string $capability): bool {
    if (!isLoggedIn()) return false;
    
    // Super Admins have access to everything
    if (isset($_SESSION['admin_role']) && $_SESSION['admin_role'] === 'super_admin') {
        return true;
    }
    
    // Check specific user permissions
    $perms = $_SESSION['admin_permissions'] ?? [];
    return is_array($perms) && in_array($capability, $perms);
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
        'role' => $_SESSION['admin_role'] ?? null,
        'permissions' => $_SESSION['admin_permissions'] ?? []
    ];
}

function loginAdmin(int $id, string $name, string $role, ?string $permissions = null): void {
    $_SESSION['admin_id'] = $id;
    $_SESSION['admin_name'] = $name;
    $_SESSION['admin_role'] = $role;
    $_SESSION['admin_permissions'] = $permissions ? json_decode($permissions, true) : [];
    $_SESSION['last_activity'] = time();
    $_SESSION['is_locked'] = false;
    $_SESSION['failed_unlock_attempts'] = 0;
    unset($_SESSION['locked_page']);
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

function verifyCsrfToken(?string $token): bool {
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

function requirePermission(string $capability): void {
    if (!hasPermission($capability)) {
        header("Location: dashboard?error=unauthorized");
        exit;
    }
}
?>
