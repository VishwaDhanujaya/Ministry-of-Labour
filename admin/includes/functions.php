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
/**
 * Resolves the correct physical file path relative to the current script execution.
 * Checks first relative to the current directory (legacy uploads/ in admin),
 * and falls back to project root.
 *
 * @param string $path
 * @return string
 */
function resolvePhysicalPath(string $path): string {
    if (empty($path)) return '';
    // If it's already an absolute path
    if (strpos($path, ':/') !== false || strpos($path, ':\\') !== false || strpos($path, '/') === 0) {
        return $path;
    }
    // Check if file exists relative to current folder (e.g. inside admin/)
    if (file_exists($path)) {
        return $path;
    }
    // Check if file exists relative to project root (e.g. check ../path)
    if (file_exists('../' . $path)) {
        return '../' . $path;
    }
    // Default fallback
    return $path;
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
    
    // Transliterate Sinhala/Tamil characters to ASCII phonetics
    $transliterated = transliterateNonAscii($basename);
    
    // Replace non alphanumeric with dash
    $slug = preg_replace('/[^a-z0-9]+/i', '-', strtolower($transliterated));
    $slug = trim($slug, '-');
    if (empty($slug)) {
        $slug = ($ext === 'pdf') ? 'document' : 'image';
    }
    
    $uniquePart = bin2hex(random_bytes(4));
    $filename = $slug . '-' . $uniquePart . '.' . $ext;
    
    // Normalize destination directory (e.g. redirect legacy assets/img/home to uploads/sliders)
    $cleanDest = trim($destinationDir, '/\\');
    if ($cleanDest === '..assets/img/home' || $cleanDest === '../assets/img/home' || $cleanDest === 'assets/img/home') {
        $cleanDest = 'uploads/sliders';
    }
    
    // Determine the absolute path on disk relative to admin/ folder
    $adminRoot = str_replace('\\', '/', realpath(__DIR__ . '/..'));
    $finalDir = $adminRoot . '/' . $cleanDest;
    
    if (!is_dir($finalDir)) {
        mkdir($finalDir, 0755, true);
    }
    
    $targetPath = $finalDir . '/' . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        // Compress / resize images if GD extension is available
        if (in_array($mimeType, ['image/jpeg', 'image/png', 'image/webp'])) {
            compressOrResizeImage($targetPath, 1920, 85);
        }
        // Return path relative to the admin folder (e.g. 'uploads/news/filename.jpg')
        $dbPath = $cleanDest . '/' . $filename;
        return ['success' => true, 'filename' => $filename, 'path' => $dbPath];
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

/**
 * Render standard trilingual PDF upload widget
 *
 * @param array $config
 * @return void
 */
function renderTrilingualPdfUploadFields(array $config): void {
    $prefix    = $config['file_input_prefix'] ?? 'pdf_file';
    $idPrefix  = $config['file_input_id_prefix'] ?? 'procPdf'; // e.g. procPdf, noticePdf, pubPdf, actPdf
    $cPrefix   = $config['container_id_prefix'] ?? 'pdfViewContainer';
    $lPrefix   = $config['link_id_prefix'] ?? 'pdfLink';
    $existing  = $config['existing_paths'] ?? ['en' => '', 'si' => '', 'ta' => ''];

    $langs = [
        'en' => ['label' => 'PDF File (English)', 'input_name' => $prefix,       'input_id' => $idPrefix . 'En', 'container_id' => $cPrefix . 'En', 'link_id' => $lPrefix . 'En'],
        'si' => ['label' => 'PDF File (Sinhala)', 'input_name' => $prefix . '_si', 'input_id' => $idPrefix . 'Si', 'container_id' => $cPrefix . 'Si', 'link_id' => $lPrefix . 'Si'],
        'ta' => ['label' => 'PDF File (Tamil)',   'input_name' => $prefix . '_ta', 'input_id' => $idPrefix . 'Ta', 'container_id' => $cPrefix . 'Ta', 'link_id' => $lPrefix . 'Ta'],
    ];

    echo '<div class="grid grid-cols-1 md:grid-cols-3 gap-5">';
    foreach ($langs as $lang => $def) {
        $showClass = !empty($existing[$lang]) ? 'flex' : 'hidden';
        echo '<div>';
        echo '<label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider mb-2">' . htmlspecialchars($def['label']) . '</label>';
        echo '<input type="file" name="' . htmlspecialchars($def['input_name']) . '" id="' . htmlspecialchars($def['input_id']) . '" accept="application/pdf" class="w-full text-[12px] text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-[12px] file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all cursor-pointer">';
        echo '<div id="' . htmlspecialchars($def['container_id']) . '" class="' . $showClass . ' items-center justify-between p-2.5 bg-slate-50 border border-slate-200/80 rounded-xl mt-2 select-none animate-fadeIn">';
        echo '<div class="flex items-center gap-2 min-w-0">';
        echo '<svg class="w-4 h-4 text-red-500 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 012 0h4a1 1 0 110 2H8a1 1 0 01-1-1z" clip-rule="evenodd"/></svg>';
        echo '<a id="' . htmlspecialchars($def['link_id']) . '" href="#" target="_blank" class="text-[11.5px] font-semibold text-primary hover:underline truncate">View PDF</a>';
        echo '</div>';
        echo '<button type="button" onclick="deletePdfAjax(\'' . htmlspecialchars($lang) . '\')" class="text-slate-400 hover:text-red-600 transition-colors p-1" title="Delete PDF">';
        echo '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
    }
    echo '</div>';
}

/**
 * Render standard trilingual text inputs/textareas/quill editors in a clean tabbed layout
 *
 * @param array $config
 * @return void
 */
function renderTrilingualInputFields(array $config): void {
    $tabGroupId = $config['tab_group_id'] ?? 'lang_tabs';
    $fields = $config['fields'] ?? [];
    $existing = $config['existing'] ?? [];

    $langs = [
        'en' => ['label' => 'English', 'suffix' => ''],
        'si' => ['label' => 'Sinhala', 'suffix' => '_si'],
        'ta' => ['label' => 'Tamil', 'suffix' => '_ta']
    ];

    // 1. Output the Tabs header
    echo '<div class="inline-flex p-1 bg-slate-100/80 backdrop-blur-md rounded-2xl mb-4 shadow-inner border border-slate-200/40 relative ' . htmlspecialchars($tabGroupId) . '-btns">';
    foreach ($langs as $lang => $langDef) {
        $activeClass = $lang === 'en' ? 'active bg-white shadow-sm text-secondary font-bold' : 'text-slate-500 font-semibold hover:bg-slate-50/50';
        echo '<button type="button" class="lang-tab-btn px-5 py-2 text-[12px] rounded-xl transition-all focus:outline-none relative z-10 ' . $activeClass . '" data-target="' . htmlspecialchars($tabGroupId . '-' . $lang) . '">' . htmlspecialchars($langDef['label']) . '</button>';
    }
    echo '</div>';

    // 2. Output the Tab Contents
    foreach ($langs as $lang => $langDef) {
        $displayClass = $lang === 'en' ? 'block' : 'hidden';
        echo '<div id="' . htmlspecialchars($tabGroupId . '-' . $lang) . '" class="lang-tab-content ' . $displayClass . ' space-y-4">';
        
        foreach ($fields as $field) {
            $fieldName = $field['name'] . $langDef['suffix'];
            $fieldId = $field['id_prefix'] . ucfirst($lang);
            $fieldLabel = $field['label'] . ' (' . $langDef['label'] . ')';
            $required = ($lang === 'en' && ($field['required'] ?? false)) ? 'required' : '';
            $placeholder = $field['placeholder'] ?? '';
            $type = $field['type'] ?? 'input';
            $val = htmlspecialchars($existing[$fieldName] ?? '');

            echo '<div>';
            echo '<div class="flex justify-between items-center mb-2">';
            echo '<label class="block text-[11px] font-bold text-slate-500 uppercase tracking-wider">' . htmlspecialchars($fieldLabel) . ($required ? ' <span class="text-red-500">*</span>' : '') . '</label>';
            
            // Auto translate button
            echo '<button type="button" onclick="autoTranslateTrilingualField(\'' . htmlspecialchars($tabGroupId) . '\', \'' . htmlspecialchars($field['name']) . '\', \'' . htmlspecialchars($field['id_prefix']) . '\', \'' . htmlspecialchars($lang) . '\', \'' . htmlspecialchars($type) . '\')" id="translate-btn-' . htmlspecialchars($field['id_prefix']) . '-' . htmlspecialchars($lang) . '" class="text-[10px] bg-blue-50 hover:bg-blue-100 text-blue-600 px-2.5 py-1 rounded-lg border border-blue-100 transition-all flex items-center gap-1 font-bold">';
            echo '<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"></path></svg>';
            echo 'Auto Translate';
            echo '</button>';
            echo '</div>';

            if ($type === 'input') {
                echo '<input type="text" name="' . htmlspecialchars($fieldName) . '" id="' . htmlspecialchars($fieldId) . '" ' . $required . ' value="' . $val . '" placeholder="' . htmlspecialchars($placeholder) . '" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 placeholder-slate-400 font-semibold">';
            } elseif ($type === 'textarea') {
                echo '<textarea name="' . htmlspecialchars($fieldName) . '" id="' . htmlspecialchars($fieldId) . '" ' . $required . ' placeholder="' . htmlspecialchars($placeholder) . '" rows="4" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200/80 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary text-[13px] text-slate-700 placeholder-slate-400 font-semibold">' . $val . '</textarea>';
            } elseif ($type === 'quill') {
                echo '<input type="hidden" name="' . htmlspecialchars($fieldName) . '" id="' . htmlspecialchars($fieldId) . '_input" value="' . $val . '">';
                echo '<div class="bg-white rounded-xl border border-slate-200/80 overflow-hidden">';
                echo '<div id="' . htmlspecialchars($fieldId) . '" style="height: 150px;"></div>';
                echo '</div>';
            }
            echo '</div>';
        }
        
        echo '</div>';
    }
}

/**
 * Phonetically transliterate Sinhala and Tamil Unicode characters to safe Latin ASCII characters
 *
 * @param string $text
 * @return string
 */
function transliterateNonAscii(string $text): string {
    $map = [
        // Sinhala Consonants
        'ක' => 'k', 'ඛ' => 'kh', 'ග' => 'g', 'ඝ' => 'gh', 'ඞ' => 'ng', 'ඟ' => 'ng',
        'ච' => 'ch', 'ඡ' => 'chh', 'ජ' => 'j', 'ඣ' => 'jh', 'ඤ' => 'ny',
        'ට' => 't', 'ඨ' => 'th', 'ඩ' => 'd', 'ඪ' => 'dh', 'ණ' => 'n',
        'ත' => 't', 'ථ' => 'th', 'ද' => 'd', 'ධ' => 'dh', 'න' => 'n',
        'ප' => 'p', 'ඵ' => 'ph', 'බ' => 'b', 'භ' => 'bh', 'ම' => 'm',
        'ය' => 'y', 'ර' => 'r', 'ල' => 'l', 'ව' => 'v', 'ශ' => 'sh', 'ෂ' => 'sh',
        'ස' => 's', 'හ' => 'h', 'ළ' => 'l', 'ෆ' => 'f', 'ං' => 'n', 'ඃ' => 'h',
        
        // Sinhala Vowels & Diacritics
        'අ' => 'a', 'ආ' => 'aa', 'ඇ' => 'ae', 'ඈ' => 'aee', 'ඉ' => 'i', 'ඊ' => 'ii',
        'උ' => 'u', 'ඌ' => 'uu', 'එ' => 'e', 'ඒ' => 'ee', 'ඔ' => 'o', 'ඕ' => 'oo',
        'ා' => 'a', 'ැ' => 'ae', 'ෑ' => 'aee', 'ි' => 'i', 'ී' => 'ii',
        'ු' => 'u', 'ූ' => 'uu', 'ෘ' => 'ru', 'ෙ' => 'e', 'ේ' => 'ee',
        'ො' => 'o', 'ෝ' => 'oo', 'ෞ' => 'au', '්' => '',
        
        // Tamil Consonants
        'க' => 'k', 'ங' => 'ng', 'ச' => 'cha', 'ஞ' => 'ny', 'ட' => 't', 'ண' => 'n',
        'த' => 'th', 'ந' => 'n', 'ப' => 'p', 'ம' => 'm', 'ய' => 'y', 'ர' => 'r',
        'ல' => 'l', 'வ' => 'v', 'ழ' => 'zh', 'ள' => 'l', 'ற' => 'r', 'ன' => 'n',
        'ஜ' => 'j', 'ஷ' => 'sh', 'ஸ' => 's', 'ஹ' => 'h',
        
        // Tamil Vowels & Diacritics
        'அ' => 'a', 'ஆ' => 'aa', 'இ' => 'i', 'ஈ' => 'ee', 'உ' => 'u', 'ஊ' => 'oo',
        'எ' => 'e', 'ஏ' => 'ae', 'ஐ' => 'ai', 'ஒ' => 'o', 'ஓ' => 'oe', 'ஔ' => 'au',
        'ா' => 'a', 'ி' => 'i', 'ீ' => 'ee', 'ு' => 'u', 'ூ' => 'oo',
        'ெ' => 'e', 'ே' => 'ae', 'ை' => 'ai', 'ொ' => 'o', 'ோ' => 'oe', 'ௌ' => 'au', '்' => ''
    ];
    return strtr($text, $map);
}

require_once __DIR__ . '/table-helper.php';
?>
