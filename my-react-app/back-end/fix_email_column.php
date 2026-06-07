<?php
// Script to add email column to authentication table
require_once 'connection.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Fix Email Column</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .success { color: green; padding: 10px; background: #d4edda; border: 1px solid #c3e6cb; border-radius: 4px; margin: 10px 0; }
        .error { color: red; padding: 10px; background: #f8d7da; border: 1px solid #f5c6cb; border-radius: 4px; margin: 10px 0; }
        .info { color: #004085; padding: 10px; background: #d1ecf1; border: 1px solid #bee5eb; border-radius: 4px; margin: 10px 0; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Fix Email Column in Authentication Table</h1>
        
        <?php
        try {
            // Check if email column exists
            $stmt = $pdo->query("SHOW COLUMNS FROM authentication LIKE 'email'");
            $column_exists = $stmt->rowCount() > 0;
            
            if ($column_exists) {
                echo '<div class="info">✓ Email column already exists!</div>';
                
                // Update admin user email if empty
                $stmt = $pdo->prepare("UPDATE authentication SET email = 'admin@clinic.com' WHERE username = 'admin' AND (email = '' OR email IS NULL)");
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                    echo '<div class="success">✓ Updated admin user email to admin@clinic.com</div>';
                } else {
                    echo '<div class="info">ℹ Admin user already has an email</div>';
                }
            } else {
                // Add email column
                $pdo->exec("ALTER TABLE authentication ADD COLUMN email VARCHAR(255) NOT NULL DEFAULT '' AFTER password");
                echo '<div class="success">✓ Email column added successfully!</div>';
                
                // Update admin user email
                $stmt = $pdo->prepare("UPDATE authentication SET email = 'admin@clinic.com' WHERE username = 'admin'");
                $stmt->execute();
                echo '<div class="success">✓ Updated admin user email to admin@clinic.com</div>';
            }
            
            // Show current table structure
            echo '<div class="info"><strong>Current authentication table structure:</strong><br>';
            $stmt = $pdo->query("DESCRIBE authentication");
            $columns = $stmt->fetchAll();
            echo '<table border="1" cellpadding="5" style="margin-top: 10px; border-collapse: collapse; width: 100%;">';
            echo '<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th></tr>';
            foreach ($columns as $col) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($col['Field']) . '</td>';
                echo '<td>' . htmlspecialchars($col['Type']) . '</td>';
                echo '<td>' . htmlspecialchars($col['Null']) . '</td>';
                echo '<td>' . htmlspecialchars($col['Key']) . '</td>';
                echo '<td>' . htmlspecialchars($col['Default'] ?? 'NULL') . '</td>';
                echo '</tr>';
            }
            echo '</table></div>';
            
            echo '<div class="success"><strong>✅ Fix completed! You can now <a href="login.php">go to login page</a></strong></div>';
            
        } catch(PDOException $e) {
            echo '<div class="error">❌ Error: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
        ?>
    </div>
</body>
</html>

