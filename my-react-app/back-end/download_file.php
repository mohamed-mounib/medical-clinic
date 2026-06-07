<?php
require_once 'connection.php';
require_once 'check_session.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;

try {
    $stmt = $pdo->prepare("SELECT medical_file FROM appointments WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $appointment = $stmt->fetch();
    
    if ($appointment && !empty($appointment['medical_file'])) {
        $file_path = '../uploads/' . $appointment['medical_file'];
        
        if (file_exists($file_path)) {
            // Get file info
            $file_name = $appointment['medical_file'];
            $file_size = filesize($file_path);
            $file_type = mime_content_type($file_path);
            
            // Set headers for file download
            header('Content-Type: ' . $file_type);
            header('Content-Disposition: attachment; filename="' . $file_name . '"');
            header('Content-Length: ' . $file_size);
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            
            // Output file
            readfile($file_path);
            exit;
        } else {
            header('Location: manage_appointments.php?error=file_not_found');
            exit;
        }
    } else {
        header('Location: manage_appointments.php?error=no_file');
        exit;
    }
} catch(PDOException $e) {
    header('Location: manage_appointments.php?error=database_error');
    exit;
}
?>

