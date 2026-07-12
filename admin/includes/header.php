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
    <?php
    $css_path = dirname(dirname(__DIR__)) . '/assets/css/style.css';
    $css_version = file_exists($css_path) ? filemtime($css_path) : time();
    ?>
    <link rel="stylesheet" href="<?= $base_url ?>assets/css/style.css?v=<?= $css_version ?>">
    
    <style>
        body, input, select, textarea, button {
            font-family: 'Inter', sans-serif !important;
        }
        h1, h2, h3, h4, h5, h6, .font-montserrat {
            font-family: 'Montserrat', sans-serif !important;
        }
        .font-inter {
            font-family: 'Inter', sans-serif !important;
        }
        .font-mono {
            font-family: 'Inter', sans-serif !important;
            letter-spacing: 0.05em;
        }
        select {
            appearance: none !important;
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%23475569' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E") !important;
            background-position: right 0.75rem center !important;
            background-size: 1.15rem !important;
            background-repeat: no-repeat !important;
            padding-right: 2.5rem !important;
            background-color: #F8FAFC !important;
            border: 1px solid #E2E8F0 !important;
            border-radius: 0.75rem !important;
            color: #334155 !important;
            transition: all 150ms ease !important;
            font-size: 13px !important;
            font-weight: 500 !important;
        }
        select:hover {
            border-color: #CBD5E1 !important;
            background-color: #F1F5F9 !important;
        }
        select:focus {
            outline: none !important;
            background-color: #FFFFFF !important;
            border-color: #13273F !important;
            box-shadow: 0 0 0 3px rgba(19, 39, 63, 0.08) !important;
        }
    </style>
</head>
<body class="bg-[#F8F9FA] text-gray-800 antialiased font-inter h-screen flex overflow-hidden">
