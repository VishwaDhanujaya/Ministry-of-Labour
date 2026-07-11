<?php
require_once 'includes/auth.php';
logoutAdmin();
$timeout = isset($_GET['timeout']) ? '?timeout=1' : '';
header("Location: login" . $timeout);
exit;
?>
