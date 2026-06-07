<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'medical_clinic');
define('DB_USER', 'root');
define('DB_PASS', ''); // Change this to your MySQL password if you have one set

try {
    // Try different connection methods for empty password
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    
    // If password is empty, try without password parameter first
    if (DB_PASS === '') {
        // Method 1: Try with null
        try {
            $pdo = new PDO($dsn, DB_USER, null, $options);
        } catch(PDOException $e1) {
            // Method 2: Try with empty string
            try {
                $pdo = new PDO($dsn, DB_USER, '', $options);
            } catch(PDOException $e2) {
                // Method 3: Try without password parameter (PHP 7.4+)
                $pdo = new PDO($dsn, DB_USER, $options);
            }
        }
    } else {
        $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    }
} catch(PDOException $e) {
    die(json_encode([
        'error' => 'Database connection failed: ' . $e->getMessage()
    ]));
}
?>