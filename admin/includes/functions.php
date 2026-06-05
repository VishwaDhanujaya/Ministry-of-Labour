<?php
// functions.php

function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

function handleFileUpload($file, $destinationDir, $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'], $maxSize = 5242880) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error.'];
    }

    if ($file['size'] > $maxSize) {
        return ['success' => false, 'error' => 'File size exceeds maximum limit.'];
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type.'];
    }

    // Strict Extension Allowlist to prevent RCE
    $info = pathinfo($file['name']);
    $ext = strtolower($info['extension'] ?? '');
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];
    if (!in_array($ext, $allowedExtensions)) {
        return ['success' => false, 'error' => 'Invalid file extension. Only JPG, PNG, and WEBP are allowed.'];
    }

    $basename = $info['filename'];
    
    // Replace non alphanumeric with dash
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($basename));
    $slug = trim($slug, '-');
    if (empty($slug)) $slug = 'image';
    
    $uniquePart = substr(uniqid(), -5);
    $filename = $slug . '-' . $uniquePart . '.' . $ext;
    
    // Organize by Year/Month
    $yearMonth = date('Y/m');
    $finalDir = rtrim($destinationDir, '/') . '/' . $yearMonth;
    
    if (!is_dir($finalDir)) {
        mkdir($finalDir, 0755, true);
    }
    
    $targetPath = $finalDir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Return full path so callers can use $uploadResult['path'] directly
        return ['success' => true, 'filename' => $filename, 'path' => $targetPath];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

function getInitials($name) {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $w) {
        if (!empty($w)) {
            $initials .= strtoupper($w[0]);
        }
    }
    return substr($initials, 0, 2);
}
?>
