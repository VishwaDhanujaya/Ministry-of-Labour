<?php
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/functions.php';

requireLogin();

// Compute an absolute base URL so assets load correctly under URL rewriting.
// e.g. if the site root is /Ministry-of-Labour/, base_url = '/Ministry-of-Labour/'
$scriptDir   = str_replace('\\', '/', dirname(dirname(dirname(__FILE__)))); // project root (absolute filesystem)
$docRoot     = str_replace('\\', '/', rtrim($_SERVER['DOCUMENT_ROOT'], '/'));
$base_path   = substr($scriptDir, strlen($docRoot)); // e.g. '/Ministry-of-Labour'
$base_url    = rtrim($base_path, '/') . '/';          // e.g. '/Ministry-of-Labour/'
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
