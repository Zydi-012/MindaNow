<?php
session_start();
require_once '../Includes/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Check if password is hashed or plain text
        $passwordMatch = false;
        
        if (password_get_info($user['password'])['algo'] !== null) {
            // Password is hashed, use password_verify
            $passwordMatch = password_verify($password, $user['password']);
        } else {
            // Password is plain text, direct comparison
            $passwordMatch = ($password === $user['password']);
        }
        
        if ($passwordMatch) {
            if ($user['role'] === 'admin') {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Access denied. Admin only.";
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - MindaNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #1a3a2a 0%, #2d6a4f 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: white;
            border-radius: 12px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            max-width: 400px;
            width: 100%;
        }
        .logo {
            font-family: 'Bebas Neue', sans-serif;
            font-size: 2.5rem;
            text-align: center;
            margin-bottom: 2rem;
            color: #1a3a2a;
        }
        .logo span { color: #d4a253; }
    </style>
</head>
<body>
    <div class="login-card">
        <div class="logo">Minda<span>Now</span></div>
        <h5 class="text-center mb-4">Admin Login</h5>
        
        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="username" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
        
        <div class="text-center mt-3">
            <a href="../Public/index.php" class="text-muted small">← Back to Website</a>
        </div>
    </div>
</body>
</html>
