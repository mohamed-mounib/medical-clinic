<?php
// Set error handling
error_reporting(E_ALL);
ini_set('display_errors', 0); // Don't display errors, return as JSON
ini_set('log_errors', 1);

// Function to send JSON error response
function sendError($message, $code = 400) {
    header('Content-Type: application/json');
    http_response_code($code);
    echo json_encode(['error' => $message]);
    exit;
}

// CORS Configuration - Allow requests from React dev server and localhost
$allowed_origins = [
    'http://localhost:5173',
    'http://localhost:3000',
    'http://127.0.0.1:5173',
    'http://127.0.0.1:3000'
];

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';
if (in_array($origin, $allowed_origins)) {
    header('Access-Control-Allow-Origin: ' . $origin);
} else {
    // Fallback for direct access
    header('Access-Control-Allow-Origin: *');
}

header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With, Accept');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 86400');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Catch any fatal errors
register_shutdown_function(function() {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'error' => 'Server error occurred',
            'message' => $error['message'],
            'file' => $error['file'],
            'line' => $error['line']
        ]);
    }
});

// Log request for debugging (remove in production)
error_log("Appointment request received. Method: " . $_SERVER['REQUEST_METHOD']);
if (!empty($_POST)) {
    error_log("POST data: " . print_r($_POST, true));
}
if (!empty($_FILES)) {
    error_log("FILES data: " . print_r(array_keys($_FILES), true));
}

require_once 'connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize and validate inputs
    $first_name = isset($_POST['first_name']) ? trim($_POST['first_name']) : '';
    $last_name = isset($_POST['last_name']) ? trim($_POST['last_name']) : '';
    $birthdate = isset($_POST['birthdate']) ? trim($_POST['birthdate']) : '';
    $gender = isset($_POST['gender']) ? trim($_POST['gender']) : '';
    $requested_service = isset($_POST['requested_service']) ? trim($_POST['requested_service']) : '';
    $preferred_date = isset($_POST['preferred_date']) ? trim($_POST['preferred_date']) : '';
    $preferred_time = isset($_POST['preferred_time']) ? trim($_POST['preferred_time']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
    $address = isset($_POST['address']) ? trim($_POST['address']) : '';
    $allergies_history = isset($_POST['allergies_history']) ? trim($_POST['allergies_history']) : '';
    $selected_doctor = isset($_POST['selected_doctor']) ? trim($_POST['selected_doctor']) : '';

    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || 
        empty($gender) || empty($requested_service) || empty($preferred_date) || 
        empty($preferred_time) || empty($email) || empty($phone) || empty($address)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'All required fields must be filled']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Invalid email format']);
        exit;
    }

    // Handle file upload
    $medical_file = null;
    if (isset($_FILES['medical_file']) && $_FILES['medical_file']['error'] === UPLOAD_ERR_OK) {
        $allowed_types = ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png'];
        $file_type = $_FILES['medical_file']['type'];
        $file_size = $_FILES['medical_file']['size'];
        
        // Validate file type
        if (!in_array($file_type, $allowed_types)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Only PDF, JPG, and PNG files are allowed']);
            exit;
        }
        
        // Validate file size (5MB max)
        if ($file_size > 5 * 1024 * 1024) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'File size must be less than 5MB']);
            exit;
        }
        
        // Create uploads directory if it doesn't exist
        $upload_dir = '../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        // Generate unique filename
        $file_extension = pathinfo($_FILES['medical_file']['name'], PATHINFO_EXTENSION);
        $medical_file = uniqid() . '_' . time() . '.' . $file_extension;
        $upload_path = $upload_dir . $medical_file;
        
        // Move uploaded file
        if (!move_uploaded_file($_FILES['medical_file']['tmp_name'], $upload_path)) {
            header('Content-Type: application/json');
            echo json_encode(['error' => 'Failed to upload file']);
            exit;
        }
    }

    try {
        // Insert into database
        $sql = "INSERT INTO appointments (
            first_name, last_name, birthdate, gender, requested_service, 
            preferred_date, preferred_time, email, phone, address, 
            allergies_history, selected_doctor, medical_file, created_at
        ) VALUES (
            :first_name, :last_name, :birthdate, :gender, :requested_service,
            :preferred_date, :preferred_time, :email, :phone, :address,
            :allergies_history, :selected_doctor, :medical_file, NOW()
        )";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => htmlspecialchars($first_name, ENT_QUOTES, 'UTF-8'),
            ':last_name' => htmlspecialchars($last_name, ENT_QUOTES, 'UTF-8'),
            ':birthdate' => $birthdate,
            ':gender' => htmlspecialchars($gender, ENT_QUOTES, 'UTF-8'),
            ':requested_service' => htmlspecialchars($requested_service, ENT_QUOTES, 'UTF-8'),
            ':preferred_date' => $preferred_date,
            ':preferred_time' => $preferred_time,
            ':email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
            ':phone' => htmlspecialchars($phone, ENT_QUOTES, 'UTF-8'),
            ':address' => htmlspecialchars($address, ENT_QUOTES, 'UTF-8'),
            ':allergies_history' => htmlspecialchars($allergies_history, ENT_QUOTES, 'UTF-8'),
            ':selected_doctor' => htmlspecialchars($selected_doctor, ENT_QUOTES, 'UTF-8'),
            ':medical_file' => $medical_file
        ]);
        
        // Send email notification (optional)
        $email_sent = false;
        try {
            $to = $email;
            $subject = 'Appointment Request Confirmation - Medical Clinic';
            $message = "Dear {$first_name} {$last_name},\n\n";
            $message .= "Thank you for submitting your appointment request. We have received your request with the following details:\n\n";
            $message .= "Service: {$requested_service}\n";
            $message .= "Preferred Date: " . date('F d, Y', strtotime($preferred_date)) . "\n";
            $message .= "Preferred Time: " . date('h:i A', strtotime($preferred_time)) . "\n";
            if (!empty($selected_doctor)) {
                $message .= "Selected Doctor: {$selected_doctor}\n";
            }
            $message .= "\nWe will contact you shortly to confirm your appointment.\n\n";
            $message .= "Best regards,\nMedical Clinic Team";
            
            $headers = "From: Medical Clinic <noreply@medicalclinic.com>\r\n";
            $headers .= "Reply-To: info@medicalclinic.com\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
            
            $email_sent = @mail($to, $subject, $message, $headers);
        } catch(Exception $e) {
            // Email sending failed, but don't fail the appointment submission
            $email_sent = false;
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => 'Your appointment request has been submitted successfully.' . ($email_sent ? ' A confirmation email has been sent to your email address.' : '')
        ]);
        
    } catch(PDOException $e) {
        // If database error, delete uploaded file if exists
        if ($medical_file && file_exists($upload_dir . $medical_file)) {
            unlink($upload_dir . $medical_file);
        }
        header('Content-Type: application/json');
        echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
    }
    
} else {
    header('Content-Type: application/json');
    http_response_code(405);
    echo json_encode(['error' => 'Invalid request method. Only POST is allowed.']);
}
?>