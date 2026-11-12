<?php
/**
 * Database Connection for DS Construction
 * Uses Standard MySQL / MariaDB (Compatible with XAMPP, phpMyAdmin, and Live Servers)
 */

// MySQL Database Credentials (Standard XAMPP default)
define('DB_HOST', 'localhost');
define('DB_PORT', '3306');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'ds_construction');

try {
    // Connect to MySQL server (without DB first, to ensure database exists)
    $dsnNoDb = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";charset=utf8mb4";
    $initPdo = new PDO($dsnNoDb, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Ensure database exists
    $initPdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");

    // Connect to the specific database
    $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $pdo = new PDO($dsn, DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    // Verify if tables exist, auto-import schema if empty
    $checkTable = $pdo->query("SHOW TABLES LIKE 'settings'");
    if ($checkTable->rowCount() === 0) {
        $sqlDumpFile = __DIR__ . '/../database/ds_construction.sql';
        if (file_exists($sqlDumpFile)) {
            $sqlContent = file_get_contents($sqlDumpFile);
            $pdo->exec($sqlContent);
        }
    }

} catch (PDOException $e) {
    die("<div style='font-family:sans-serif; padding:2rem; background:#fee2e2; color:#991b1b; border:1px solid #f87171; border-radius:8px; max-width:600px; margin:3rem auto;'>"
        . "<h3 style='margin-top:0;'>MySQL Connection Error</h3>"
        . "<p>Could not connect to MySQL server. Please ensure <strong>MySQL</strong> is started in your <strong>XAMPP Control Panel</strong>.</p>"
        . "<p><small>Details: " . htmlspecialchars($e->getMessage()) . "</small></p>"
        . "</div>");
}

/**
 * Helper to fetch all site settings as associative array
 */
function getSettings($pdo) {
    static $settingsCache = null;
    if ($settingsCache !== null) {
        return $settingsCache;
    }
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settingsCache = [];
    while ($row = $stmt->fetch()) {
        $settingsCache[$row['setting_key']] = $row['setting_value'];
    }
    return $settingsCache;
}
