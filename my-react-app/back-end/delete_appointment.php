<?php
require_once 'connection.php';
require_once 'check_session.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    try {
        // Get appointment to find medical file
        $stmt = $pdo->prepare("SELECT medical_file FROM appointments WHERE id = :id");
        $stmt->execute([':id' => $id]);
        $appointment = $stmt->fetch();
        
        if ($appointment) {
            // Delete the appointment
            $stmt = $pdo->prepare("DELETE FROM appointments WHERE id = :id");
            $stmt->execute([':id' => $id]);
            
            // Delete medical file if exists
            if (!empty($appointment['medical_file'])) {
                $file_path = '../uploads/' . $appointment['medical_file'];
                if (file_exists($file_path)) {
                    unlink($file_path);
                }
            }
        }
    } catch(PDOException $e) {
        // Error handling
    }
}

header('Location: manage_appointments.php');
exit;
?>

