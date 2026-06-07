<?php
/**
 * Script to add the missing updated_at column to the appointments table
 * Run this in your browser at: http://localhost/my-react-app/back-end/fix_updated_at_column.php
 */

require_once 'connection.php';

try {
    echo "<h2>Fixing Database Schema...</h2>";
    
    // Add updated_at column if it doesn't exist
    $sql = "ALTER TABLE appointments 
            ADD COLUMN IF NOT EXISTS updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
    
    $pdo->exec($sql);
    
    echo "<div style='color: green; padding: 10px; background: #e8f5e9; border-radius: 4px; margin: 10px 0;'>";
    echo "✓ Column 'updated_at' has been successfully added to the appointments table!";
    echo "</div>";
    
    // Verify the column exists
    $stmt = $pdo->query("DESCRIBE appointments");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Current Table Structure:</h3>";
    echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
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
    
    echo "<p><a href='dashboard.php' style='margin-top: 20px; display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>Back to Dashboard</a></p>";
    
} catch(PDOException $e) {
    echo "<div style='color: red; padding: 10px; background: #ffebee; border-radius: 4px; margin: 10px 0;'>";
    echo "Error: " . htmlspecialchars($e->getMessage());
    echo "</div>";
    echo "<p><a href='dashboard.php' style='margin-top: 20px; display: inline-block; padding: 10px 20px; background: #007bff; color: white; text-decoration: none; border-radius: 4px;'>Back to Dashboard</a></p>";
}
?>
