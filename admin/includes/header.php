<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

requireLogin();

// Compute an absolute base URL so assets load correctly under URL rewriting.
$script_path = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); // e.g. /admin
$base_dir    = str_replace('\\', '/', dirname($script_path));            // e.g. /
if ($base_dir === '\\' || $base_dir === '/') {
    $base_dir = '';
}
$base_url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $base_dir . '/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Ministry of Labour</title>
    
    <!-- Google Fonts: Inter, Montserrat, Noto Sans Sinhala, Noto Sans Tamil -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Montserrat:wght@400;500;600;700;800&family=Noto+Sans+Sinhala:wght@400;500;600&family=Noto+Sans+Tamil:wght@400;500;600&display=swap" rel="stylesheet">
    
    <!-- Favicon -->
    <link rel="icon" href="<?= $base_url ?>assets/img/emblem.png" type="image/png">
    
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css">
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased font-inter h-screen flex overflow-hidden">
