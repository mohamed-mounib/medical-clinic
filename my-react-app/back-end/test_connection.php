<?php
// Simple test endpoint to verify PHP backend is accessible
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

echo json_encode([
    'status' => 'success',
    'message' => 'Backend is accessible!',
    'server_time' => date('Y-m-d H:i:s'),
    'php_version' => phpversion()
]);
?>

