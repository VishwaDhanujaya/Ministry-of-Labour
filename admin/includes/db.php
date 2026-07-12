<?php
date_default_timezone_set('Asia/Colombo');

// db.php
$envPath = __DIR__ . '/../../.env';
$app_env = 'production'; // Default to production for safety
$env = [];

if (file_exists($envPath)) {
    if (function_exists('parse_ini_file')) {
        $env = @parse_ini_file($envPath);
    }
    if (empty($env)) {
        // Fallback manual parser if parse_ini_file is disabled or failed
        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        if (is_array($lines)) {
            foreach ($lines as $line) {
                if (strpos(trim($line), '#') === 0) continue;
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $env[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
                }
            }
        }
    }
}

$host = $env['DB_HOST'] ?? '127.0.0.1';
if ($host === 'localhost') {
    $host = '127.0.0.1';
}
$dbname = $env['DB_NAME'] ?? 'mol_db';
$user = $env['DB_USER'] ?? 'root';
$pass = $env['DB_PASS'] ?? '';
$app_env = $env['APP_ENV'] ?? 'production';

// Dynamically handle error display based on the environment
if ($app_env === 'development') {
    ini_set('display_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    error_reporting(0);
}

/**
 * Database Connection File
 *
 * Establishes a PDO connection to the MySQL database.
 * Supports environment variables for configuration.
 *
 * @package MinistryOfLabour
 * @subpackage Database
 */

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // Prevent SQL Injection via strict native prepares
} catch(PDOException $e) {
    error_log($e->getMessage());
    $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    $acceptsJson = isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'application/json') !== false;
    
    if ($isAjax || $acceptsJson) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $e->getMessage()]);
        exit;
    } else {
        echo "<html><body><h2>Database connection failed.</h2><p>" . $e->getMessage() . "</p></body></html>";
        exit;
    }
}

// Determine current language from cookie for fetching dynamic article content globally
$current_lang = isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta']) ? $_COOKIE['lang'] : 'en';

if (!function_exists('resolvePdfUrl')) {
    function resolvePdfUrl(string $path) {
        if (empty($path) || $path === '#') return '#';
        $trimmed = ltrim($path, '/');
        
        // If it is already fully qualified or external
        if (strpos($trimmed, 'http://') === 0 || strpos($trimmed, 'https://') === 0) {
            return $path;
        }
        
        // Since db.php is inside admin/includes/, project root is __DIR__/../..
        $project_root = str_replace('\\', '/', realpath(__DIR__ . '/../..'));
        $doc_root = isset($_SERVER['DOCUMENT_ROOT']) ? str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']) : '';
        
        // Calculate the web-accessible base directory relative to domain root
        $base_dir = '';
        if (!empty($doc_root)) {
            // Check if project root starts with document root case-insensitively
            if (stripos($project_root, $doc_root) === 0) {
                $base_dir = substr($project_root, strlen($doc_root));
            }
        } else {
            // Fallback for CLI execution
            $base_dir = '/Ministry-of-Labour';
        }
        
        $base_dir = str_replace('\\', '/', $base_dir);
        $base_dir = '/' . ltrim($base_dir, '/');
        if ($base_dir === '/') {
            $base_dir = '';
        }
        
        $protocol = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $base_url = $protocol . '://' . $host . $base_dir . '/';
        
        // Check physical file existence relative to project root
        $file_in_admin = $project_root . '/admin/' . $trimmed;
        $file_in_root = $project_root . '/' . $trimmed;
        
        if (file_exists($file_in_admin)) {
            return $base_url . 'admin/' . $trimmed;
        } elseif (file_exists($file_in_root)) {
            return $base_url . $trimmed;
        } else {
            return $base_url . 'admin/' . $trimmed; // fallback
        }
    }
}
