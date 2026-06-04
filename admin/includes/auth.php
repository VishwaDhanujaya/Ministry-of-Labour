<?php
// auth.php
session_start();

function isLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function requireLogin() {
    if (!isLoggedIn()) {
        header("Location: login.php");
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
