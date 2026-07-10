<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
$_SESSION['admin_id'] = 1;
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['csrf_token'] = 'test';
$_SESSION['csrf_token'] = 'test';
$_POST['title'] = 'Test Edit';
$_POST['content'] = 'Test content edit';
$_POST['publish'] = 1;
$_GET['id'] = 1;
require 'admin/news-add.php';
?>
