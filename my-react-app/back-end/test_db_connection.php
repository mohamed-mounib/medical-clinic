<?php
// Test database connection with different password options
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$results = [];

// Test with empty password
try {
    $pdo = new PDO(
        "mysql:host=localhost;dbname=medical_clinic;charset=utf8mb4",
        'root',
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $results['empty_password'] = 'SUCCESS - Connected!';
} catch(PDOException $e) {
    $results['empty_password'] = 'FAILED: ' . $e->getMessage();
}

// Test with common passwords
$common_passwords = ['root', 'password', '1234', 'admin', '123456'];
foreach ($common_passwords as $pass) {
    try {
        $pdo = new PDO(
            "mysql:host=localhost;dbname=medical_clinic;charset=utf8mb4",
            'root',
            $pass,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $results[$pass] = 'SUCCESS - Connected! Use this password: ' . $pass;
        break; // Stop on first success
    } catch(PDOException $e) {
        $results[$pass] = 'FAILED';
    }
}

echo json_encode($results, JSON_PRETTY_PRINT);
?>

