<?php
require_once 'connection.php';
require_once 'check_session.php';

// Redirect if not logged in
if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Get all appointments
try {
    $stmt = $pdo->query("SELECT * FROM appointments ORDER BY created_at DESC");
    $appointments = $stmt->fetchAll();
} catch(PDOException $e) {
    $appointments = [];
    $error_message = 'Error loading appointments: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Appointments - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
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
        .btn-action {
            padding: 5px 10px;
            margin: 2px;
            font-size: 12px;
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
        table.dataTable thead th {
            background-color: #667eea;
            color: white;
            border: none;
        }
        table.dataTable tbody tr:hover {
            background-color: #f8f9fa;
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
            <h2 class="mb-0"><i class="fas fa-calendar-check me-2"></i>Manage Appointments</h2>
            <div>
                <span class="me-3">Welcome, <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong></span>
                <a href="logout.php" class="btn-logout">
                    <i class="fas fa-sign-out-alt me-1"></i>Logout
                </a>
            </div>
        </div>

        <div class="content-card">
            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i><?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <table id="appointmentsTable" class="table table-striped table-hover" style="width:100%">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Requested Service</th>
                        <th>Preferred Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($appointment['first_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($appointment['requested_service']); ?></td>
                            <td><?php echo date('Y-m-d', strtotime($appointment['preferred_date'])); ?></td>
                            <td>
                                <a href="appointment_details.php?id=<?php echo $appointment['id']; ?>" 
                                   class="btn btn-info btn-sm btn-action" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i> Details
                                </a>
                                <a href="edit_appointment.php?id=<?php echo $appointment['id']; ?>" 
                                   class="btn btn-warning btn-sm btn-action" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="delete_appointment.php?id=<?php echo $appointment['id']; ?>" 
                                   class="btn btn-danger btn-sm btn-action" 
                                   title="Delete"
                                   onclick="return confirm('Are you sure you want to delete this appointment request?');">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                                <?php if (!empty($appointment['medical_file'])): ?>
                                    <a href="download_file.php?id=<?php echo $appointment['id']; ?>" 
                                       class="btn btn-success btn-sm btn-action" 
                                       title="Download File">
                                        <i class="fas fa-download"></i> Download
                                    </a>
                                <?php else: ?>
                                    <button class="btn btn-secondary btn-sm btn-action" disabled title="No file">
                                        <i class="fas fa-download"></i> No File
                                    </button>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#appointmentsTable').DataTable({
                "order": [[3, "desc"]], // Sort by date descending
                "pageLength": 10,
                "language": {
                    "search": "Search:",
                    "lengthMenu": "Show _MENU_ entries",
                    "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                    "infoEmpty": "No entries found",
                    "infoFiltered": "(filtered from _MAX_ total entries)"
                }
            });
        });
    </script>
</body>
</html>

