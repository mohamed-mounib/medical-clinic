<?php
require_once 'connection.php';
require_once 'check_session.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$error = '';
$success = '';

// Get appointment data
try {
    $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
    $stmt->execute([':id' => $id]);
    $appointment = $stmt->fetch();
    
    if (!$appointment) {
        header('Location: manage_appointments.php');
        exit;
    }
} catch(PDOException $e) {
    header('Location: manage_appointments.php');
    exit;
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = trim($_POST['first_name'] ?? '');
    $last_name = trim($_POST['last_name'] ?? '');
    $birthdate = trim($_POST['birthdate'] ?? '');
    $gender = trim($_POST['gender'] ?? '');
    $requested_service = trim($_POST['requested_service'] ?? '');
    $preferred_date = trim($_POST['preferred_date'] ?? '');
    $preferred_time = trim($_POST['preferred_time'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $allergies_history = trim($_POST['allergies_history'] ?? '');
    $selected_doctor = trim($_POST['selected_doctor'] ?? '');
    
    // Validate required fields
    if (empty($first_name) || empty($last_name) || empty($birthdate) || 
        empty($gender) || empty($requested_service) || empty($preferred_date) || 
        empty($preferred_time) || empty($email) || empty($phone) || empty($address)) {
        $error = 'All required fields must be filled.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } else {
        try {
            $sql = "UPDATE appointments SET 
                    first_name = :first_name,
                    last_name = :last_name,
                    birthdate = :birthdate,
                    gender = :gender,
                    requested_service = :requested_service,
                    preferred_date = :preferred_date,
                    preferred_time = :preferred_time,
                    email = :email,
                    phone = :phone,
                    address = :address,
                    allergies_history = :allergies_history,
                    selected_doctor = :selected_doctor,
                    updated_at = NOW()
                    WHERE id = :id";
            
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
                ':id' => $id
            ]);
            
            $success = 'Appointment updated successfully!';
            // Refresh appointment data
            $stmt = $pdo->prepare("SELECT * FROM appointments WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $appointment = $stmt->fetch();
        } catch(PDOException $e) {
            $error = 'Database error: ' . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Appointment - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --sidebar-width: 250px;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
        }
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px 0;
            z-index: 1000;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        .sidebar-header {
            padding: 20px;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            margin-bottom: 20px;
        }
        .sidebar-header h4 {
            margin: 0;
            font-weight: 600;
        }
        .sidebar-menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .sidebar-menu li {
            margin: 5px 0;
        }
        .sidebar-menu a {
            display: block;
            padding: 15px 25px;
            color: white;
            text-decoration: none;
            transition: all 0.3s;
        }
        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: rgba(255,255,255,0.2);
            border-left: 4px solid white;
        }
        .sidebar-menu a i {
            width: 25px;
            margin-right: 10px;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
        }
        .top-bar {
            background: white;
            padding: 20px 30px;
            margin: -30px -30px 30px -30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .content-card {
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-label {
            font-weight: 500;
            color: #333;
        }
        .btn-logout {
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            color: white;
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s;
        }
        .btn-logout:hover {
            background: rgba(255,255,255,0.3);
            color: white;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <h4><i class="fas fa-hospital me-2"></i>Admin Panel</h4>
        </div>
        <ul class="sidebar-menu">
            <li><a href="dashboard.php"><i class="fas fa-home"></i>Dashboard</a></li>
            <li><a href="manage_appointments.php" class="active"><i class="fas fa-calendar-check"></i>Manage Appointments</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <div class="top-bar">
            <h2 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Appointment</h2>
            <div>
                <a href="manage_appointments.php" class="btn btn-secondary me-2">
                    <i class="fas fa-arrow-left me-1"></i>Back to List
                </a>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>

        <div class="content-card">
            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i><?php echo htmlspecialchars($success); ?>
                </div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="first_name" name="first_name" 
                               value="<?php echo htmlspecialchars($appointment['first_name']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="last_name" name="last_name" 
                               value="<?php echo htmlspecialchars($appointment['last_name']); ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="birthdate" class="form-label">Birthdate <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="birthdate" name="birthdate" 
                               value="<?php echo $appointment['birthdate']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                        <select class="form-control" id="gender" name="gender" required>
                            <option value="Male" <?php echo $appointment['gender'] === 'Male' ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo $appointment['gender'] === 'Female' ? 'selected' : ''; ?>>Female</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($appointment['email']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone <span class="text-danger">*</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" 
                               value="<?php echo htmlspecialchars($appointment['phone']); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="address" name="address" 
                           value="<?php echo htmlspecialchars($appointment['address']); ?>" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="requested_service" class="form-label">Requested Service <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="requested_service" name="requested_service" 
                               value="<?php echo htmlspecialchars($appointment['requested_service']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="selected_doctor" class="form-label">Selected Doctor</label>
                        <input type="text" class="form-control" id="selected_doctor" name="selected_doctor" 
                               value="<?php echo htmlspecialchars($appointment['selected_doctor']); ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="preferred_date" class="form-label">Preferred Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="preferred_date" name="preferred_date" 
                               value="<?php echo $appointment['preferred_date']; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="preferred_time" class="form-label">Preferred Time <span class="text-danger">*</span></label>
                        <input type="time" class="form-control" id="preferred_time" name="preferred_time" 
                               value="<?php echo date('H:i', strtotime($appointment['preferred_time'])); ?>" required>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="allergies_history" class="form-label">Allergies / History</label>
                    <textarea class="form-control" id="allergies_history" name="allergies_history" rows="3"><?php echo htmlspecialchars($appointment['allergies_history']); ?></textarea>
                </div>
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i>Update Appointment
                    </button>
                    <a href="appointment_details.php?id=<?php echo $appointment['id']; ?>" class="btn btn-secondary">
                        <i class="fas fa-eye me-1"></i>View Details
                    </a>
                    <a href="manage_appointments.php" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

