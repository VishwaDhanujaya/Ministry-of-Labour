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

    $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('upload_', true) . '.' . $ext;
    
    if (!is_dir($destinationDir)) {
        mkdir($destinationDir, 0755, true);
    }
    
    $targetPath = $destinationDir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
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
