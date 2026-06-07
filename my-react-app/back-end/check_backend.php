<?php
// Comprehensive backend check script
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

$checks = [
    'php_version' => phpversion(),
    'server_method' => $_SERVER['REQUEST_METHOD'] ?? 'N/A',
    'post_data_received' => !empty($_POST),
    'files_data_received' => !empty($_FILES),
    'connection_file_exists' => file_exists(__DIR__ . '/connection.php'),
    'uploads_dir_exists' => is_dir(__DIR__ . '/../uploads/'),
    'uploads_dir_writable' => is_writable(__DIR__ . '/../uploads/') || is_writable(__DIR__),
];

// Test database connection
try {
    require_once 'connection.php';
    $checks['database_connected'] = true;
    $checks['database_name'] = 'medical_clinic';
    
    // Check if appointments table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'appointments'");
    $checks['appointments_table_exists'] = $stmt->rowCount() > 0;
    
    // Check if authentication table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'authentication'");
    $checks['authentication_table_exists'] = $stmt->rowCount() > 0;
    
} catch(Exception $e) {
    $checks['database_connected'] = false;
    $checks['database_error'] = $e->getMessage();
}

// Check file permissions
$checks['process_file_readable'] = is_readable(__DIR__ . '/process_appointment.php');
$checks['process_file_writable'] = is_writable(__DIR__ . '/process_appointment.php');

echo json_encode($checks, JSON_PRETTY_PRINT);
?>

