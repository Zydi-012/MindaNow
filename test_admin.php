<?php
require_once 'Includes/db.php';

echo "<h2>MindaNow Admin Users</h2>";
echo "<hr>";

// Get all users
$result = $conn->query("SELECT id, username, email, password, role FROM users");

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' style='border-collapse:collapse;'>";
    echo "<tr style='background:#f0f0f0;'>";
    echo "<th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Password Hash</th>";
    echo "</tr>";
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>{$row['id']}</td>";
        echo "<td><strong>{$row['username']}</strong></td>";
        echo "<td>{$row['email']}</td>";
        echo "<td>{$row['role']}</td>";
        echo "<td style='font-size:0.7em;'>" . substr($row['password'], 0, 30) . "...</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    echo "<br><hr>";
    echo "<h3>Test Password Verification</h3>";
    
    // Get the admin user
    $stmt = $conn->prepare("SELECT username, password FROM users WHERE role = 'admin' LIMIT 1");
    $stmt->execute();
    $admin = $stmt->get_result()->fetch_assoc();
    
    if ($admin) {
        echo "<p><strong>Admin Username:</strong> {$admin['username']}</p>";
        
        // Test common passwords
        $testPasswords = ['admin', 'Admin@1234', 'password', '123456'];
        
        echo "<p><strong>Testing passwords:</strong></p>";
        echo "<ul>";
        foreach ($testPasswords as $testPwd) {
            $match = password_verify($testPwd, $admin['password']);
            $status = $match ? "✅ MATCH" : "❌ No match";
            echo "<li><code>{$testPwd}</code> - {$status}</li>";
        }
        echo "</ul>";
        
        echo "<br><hr>";
        echo "<h3>Generate New Password</h3>";
        echo "<p>If none match, use this hash for password 'admin123':</p>";
        echo "<code style='background:#ffffcc;padding:5px;'>" . password_hash('admin123', PASSWORD_DEFAULT) . "</code>";
        
        echo "<br><br>";
        echo "<p><strong>To update password in database, run this SQL:</strong></p>";
        echo "<code style='background:#ffffcc;padding:10px;display:block;'>UPDATE users SET password = '" . password_hash('admin123', PASSWORD_DEFAULT) . "' WHERE role = 'admin';</code>";
    }
    
} else {
    echo "<p style='color:red;'>❌ No users found in database!</p>";
    echo "<p>Please import mindanow.sql first.</p>";
}

echo "<br><hr>";
echo "<a href='Admin/login.php'>Go to Admin Login</a> | ";
echo "<a href='Public/index.php'>Go to Public Website</a>";
?>
