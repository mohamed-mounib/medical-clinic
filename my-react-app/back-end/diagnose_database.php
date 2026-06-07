<?php
/**
 * Database Diagnostic Script
 * Run this to check your database structure and fix any issues
 */

require_once 'connection.php';

echo "<html><head><title>Database Diagnostic</title><style>";
echo "body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }";
echo ".success { color: green; padding: 10px; background: #e8f5e9; border-radius: 4px; margin: 10px 0; }";
echo ".error { color: red; padding: 10px; background: #ffebee; border-radius: 4px; margin: 10px 0; }";
echo ".info { color: blue; padding: 10px; background: #e3f2fd; border-radius: 4px; margin: 10px 0; }";
echo "table { border-collapse: collapse; width: 100%; margin: 10px 0; background: white; }";
echo "th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }";
echo "th { background-color: #007bff; color: white; }";
echo "</style></head><body>";

try {
    echo "<h1>Database Diagnostic Report</h1>";
    
    // Check current appointments table structure
    echo "<h2>Current Appointments Table Structure:</h2>";
    $stmt = $pdo->query("DESCRIBE appointments");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<table>";
    echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
    
    $hasUpdatedAt = false;
    foreach ($columns as $column) {
        if ($column['Field'] === 'updated_at') {
            $hasUpdatedAt = true;
        }
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
        echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
    // Now fix if needed
    if (!$hasUpdatedAt) {
        echo "<h2>Fixing Database...</h2>";
        echo "<div class='info'>The 'updated_at' column is missing. Adding it now...</div>";
        
        // Add the column
        $sql = "ALTER TABLE appointments 
                ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
        
        $pdo->exec($sql);
        
        echo "<div class='success'>✓ Column 'updated_at' has been successfully added!</div>";
        
        // Re-check the structure
        echo "<h2>Updated Appointments Table Structure:</h2>";
        $stmt = $pdo->query("DESCRIBE appointments");
        $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo "<table>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        foreach ($columns as $column) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Null']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Key']) . "</td>";
            echo "<td>" . htmlspecialchars($column['Default'] ?? 'NULL') . "</td>";
            echo "<td>" . htmlspecialchars($column['Extra']) . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";
    } else {
        echo "<div class='success'>✓ The 'updated_at' column already exists in the table!</div>";
    }
    
    // Check if there are any appointments in the database
    echo "<h2>Appointments Count:</h2>";
    $stmt = $pdo->query("SELECT COUNT(*) as count FROM appointments");
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "<div class='info'>Total appointments: " . $result['count'] . "</div>";
    
    echo "<h2>Next Steps:</h2>";
    echo "<ol>";
    echo "<li>Go back to the dashboard and try editing an appointment again</li>";
    echo "<li>The error should be resolved now</li>";
    echo "</ol>";
    
    echo "<p><a href='dashboard.php' style='margin-top: 20px; display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>← Back to Dashboard</a></p>";
    
} catch(PDOException $e) {
    echo "<div class='error'>";
    echo "<strong>Database Error:</strong><br>";
    echo htmlspecialchars($e->getMessage());
    echo "</div>";
    
    echo "<h3>Troubleshooting Steps:</h3>";
    echo "<ol>";
    echo "<li>Check your database connection in connection.php</li>";
    echo "<li>Make sure the 'medical_clinic' database exists</li>";
    echo "<li>Make sure the 'appointments' table exists</li>";
    echo "<li>Check your MySQL server is running</li>";
    echo "</ol>";
    
    echo "<p><a href='dashboard.php' style='margin-top: 20px; display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>← Back to Dashboard</a></p>";
}

echo "</body></html>";
?>
