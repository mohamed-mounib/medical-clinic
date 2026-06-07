<?php
// Simple direct connection test
header('Content-Type: text/plain');

echo "Testing MySQL connection...\n\n";

// Try with empty password
try {
    $pdo = new PDO("mysql:host=localhost;dbname=medical_clinic", 'root', '');
    echo "✓ SUCCESS with empty password!\n";
    echo "Update connection.php: define('DB_PASS', '');\n";
} catch(PDOException $e) {
    echo "✗ FAILED with empty password: " . $e->getMessage() . "\n\n";
    
    // Try with null
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=medical_clinic", 'root', null);
        echo "✓ SUCCESS with null password!\n";
        echo "The code should already handle this.\n";
    } catch(PDOException $e2) {
        echo "✗ FAILED with null: " . $e2->getMessage() . "\n\n";
        echo "You need to find your MySQL password.\n";
        echo "Check: C:\\xampp\\phpMyAdmin\\config.inc.php\n";
    }
}
?>

