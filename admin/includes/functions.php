<?php
// functions.php

/**
 * Sanitize input data to prevent XSS attacks
 *
 * @param string $data
 * @return string
 */
function sanitizeInput(string $data): string {
    return htmlspecialchars(stripslashes(trim($data)));
}

/**
 * Upload and process single file securely
 *
 * @param array $file
 * @param string $destinationDir
 * @param array $allowedTypes
 * @param int $maxSize
 * @return array
 */
function handleFileUpload(array $file, string $destinationDir, array $allowedTypes = ['image/jpeg', 'image/png', 'image/webp'], int $maxSize = 5242880): array {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return ['success' => false, 'error' => 'No file uploaded or upload error.'];
    }

    $info = pathinfo($file['name']);
    $ext = strtolower($info['extension'] ?? '');

    // Skip size limit for PDF files
    if ($ext !== 'pdf') {
        if ($file['size'] > $maxSize) {
            $maxSizeMB = round($maxSize / (1024 * 1024), 2);
            return ['success' => false, 'error' => 'File size exceeds maximum limit of ' . $maxSizeMB . 'MB.'];
        }
    }

    $mimeType = '';
    
    if (function_exists('finfo_open')) {
        $finfo = @finfo_open(FILEINFO_MIME_TYPE);
        if ($finfo !== false) {
            $mimeType = @finfo_file($finfo, $file['tmp_name']);
            @finfo_close($finfo);
        }
    }
    
    if (empty($mimeType) && function_exists('mime_content_type')) {
        $mimeType = @mime_content_type($file['tmp_name']);
    }
    
    if (empty($mimeType)) {
        // Fallback for images if all else fails
        $imgSize = @getimagesize($file['tmp_name']);
        if ($imgSize !== false && isset($imgSize['mime'])) {
            $mimeType = $imgSize['mime'];
        } else {
            $mimeType = $file['type'] ?? '';
        }
    }

    if (!in_array($mimeType, $allowedTypes)) {
        return ['success' => false, 'error' => 'Invalid file type.'];
    }

    // Strict Extension Allowlist to prevent RCE
    $info = pathinfo($file['name']);
    $ext = strtolower($info['extension'] ?? '');
    
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'pdf'];
    if (!in_array($ext, $allowedExtensions)) {
        return ['success' => false, 'error' => 'Invalid file extension. Only JPG, PNG, WEBP, and PDF are allowed.'];
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
        // Compress / resize images if GD extension is available
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            compressOrResizeImage($targetPath, 1920, 85);
        }
        // Return full path so callers can use $uploadResult['path'] directly
        return ['success' => true, 'filename' => $filename, 'path' => $targetPath];
    }
    
    return ['success' => false, 'error' => 'Failed to move uploaded file.'];
}

/**
 * Helper function to compress and resize uploaded images for web performance
 *
 * @param string $filePath
 * @param int $maxWidth
 * @param int $quality
 * @return bool
 */
function compressOrResizeImage(string $filePath, int $maxWidth = 1920, int $quality = 85): bool {
    @ini_set('memory_limit', '256M');
    if (!extension_loaded('gd') || !file_exists($filePath)) return false;

    $info = @getimagesize($filePath);
    if (!$info) return false;

    $mime = $info['mime'];
    $width = $info[0];
    $height = $info[1];

    switch ($mime) {
        case 'image/jpeg':
            $image = @imagecreatefromjpeg($filePath);
            break;
        case 'image/png':
            $image = @imagecreatefrompng($filePath);
            break;
        case 'image/webp':
            $image = @imagecreatefromwebp($filePath);
            break;
        default:
            return false;
    }

    if (!$image) return false;

    if ($width > $maxWidth) {
        $newWidth = $maxWidth;
        $newHeight = (int)round(($height / $width) * $maxWidth);
    } else {
        $newWidth = $width;
        $newHeight = $height;
    }

    $newImage = imagecreatetruecolor($newWidth, $newHeight);

    if ($mime === 'image/png' || $mime === 'image/webp') {
        imagealphablending($newImage, false);
        imagesavealpha($newImage, true);
    }

    imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

    if (function_exists('imagewebp')) {
        imagewebp($newImage, $filePath, $quality);
    } elseif ($mime === 'image/jpeg' && function_exists('imagejpeg')) {
        imagejpeg($newImage, $filePath, $quality);
    } elseif ($mime === 'image/png' && function_exists('imagepng')) {
        imagepng($newImage, $filePath, (int)round((100 - $quality) / 10));
    }

    imagedestroy($image);
    imagedestroy($newImage);

    return true;
}

/**
 * Get name initials for user avatars
 *
 * @param string $name
 * @return string
 */
function getInitials(string $name): string {
    $words = explode(' ', trim($name));
    $initials = '';
    foreach ($words as $w) {
        if (!empty($w)) {
            $initials .= strtoupper($w[0]);
        }
    }
    return substr($initials, 0, 2);
}

require_once __DIR__ . '/table-helper.php';
?>
