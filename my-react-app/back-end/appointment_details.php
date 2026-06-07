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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointment Details - Admin Panel</title>
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
        .detail-row {
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .detail-row:last-child {
            border-bottom: none;
        }
        .detail-label {
            font-weight: 600;
            color: #667eea;
            margin-bottom: 5px;
        }
        .detail-value {
            color: #333;
            font-size: 16px;
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
            <h2 class="mb-0"><i class="fas fa-info-circle me-2"></i>Appointment Details</h2>
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
            <div class="row">
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">First Name</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['first_name']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Last Name</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['last_name']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Birthdate</div>
                        <div class="detail-value"><?php echo date('F d, Y', strtotime($appointment['birthdate'])); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Gender</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['gender']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Email</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['email']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Phone</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['phone']); ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="detail-row">
                        <div class="detail-label">Address</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['address']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Requested Service</div>
                        <div class="detail-value"><?php echo htmlspecialchars($appointment['requested_service']); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Selected Doctor</div>
                        <div class="detail-value"><?php echo !empty($appointment['selected_doctor']) ? htmlspecialchars($appointment['selected_doctor']) : 'Any Available Doctor'; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Preferred Date</div>
                        <div class="detail-value"><?php echo date('F d, Y', strtotime($appointment['preferred_date'])); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Preferred Time</div>
                        <div class="detail-value"><?php echo date('h:i A', strtotime($appointment['preferred_time'])); ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Allergies / History</div>
                        <div class="detail-value"><?php echo !empty($appointment['allergies_history']) ? htmlspecialchars($appointment['allergies_history']) : 'None provided'; ?></div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Medical File</div>
                        <div class="detail-value">
                            <?php if (!empty($appointment['medical_file'])): ?>
                                <a href="download_file.php?id=<?php echo $appointment['id']; ?>" class="btn btn-success btn-sm">
                                    <i class="fas fa-download me-1"></i>Download File
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No file uploaded</span>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Submitted On</div>
                        <div class="detail-value"><?php echo date('F d, Y h:i A', strtotime($appointment['created_at'])); ?></div>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <a href="edit_appointment.php?id=<?php echo $appointment['id']; ?>" class="btn btn-warning">
                    <i class="fas fa-edit me-1"></i>Edit Appointment
                </a>
                <a href="manage_appointments.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to List
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

