<?php
// db.php
$envPath = __DIR__ . '/../../.env';
$app_env = 'production'; // Default to production for safety

if (file_exists($envPath)) {
    $env = parse_ini_file($envPath);
    $host = $env['DB_HOST'] ?? 'localhost';
    $dbname = $env['DB_NAME'] ?? 'mol_db';
    $user = $env['DB_USER'] ?? 'root';
    $pass = $env['DB_PASS'] ?? '';
    $app_env = $env['APP_ENV'] ?? 'production';
} else {
    $host = 'localhost';
    $dbname = 'mol_db';
    $user = 'root';
    $pass = '';
}

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
        echo json_encode(['success' => false, 'message' => 'Database connection failed.']);
        exit;
    } else {
        echo "<html><body><h2>Database connection failed.</h2><p>Please try again later.</p></body></html>";
        exit;
    }
}

// Determine current language from cookie for fetching dynamic article content globally
$current_lang = isset($_COOKIE['lang']) && in_array($_COOKIE['lang'], ['en', 'si', 'ta']) ? $_COOKIE['lang'] : 'en';
