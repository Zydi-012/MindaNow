<?php
session_start();
require_once 'includes/db.php';

// If already logged in, go to dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: /Mindanow/admin/dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare SQL statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        header("Location: /Mindanow/admin/dashboard.php");
        exit();

    } else {
        $error = "Invalid login credentials.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login - Mindanow</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex align-items-center" style="height:100vh;">

<div class="container">

    <div class="row justify-content-center">
        <div class="col-md-4">

            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">

                    <h4 class="text-center mb-3">Admin Login</h4>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger small">
                            <?php echo $error; ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <input type="text"
                                   name="username"
                                   class="form-control"
                                   placeholder="Username"
                                   required>
                        </div>

                        <div class="mb-3">
                            <input type="password"
                                   name="password"
                                   class="form-control"
                                   placeholder="Password"
                                   required>
                        </div>

                        <button type="submit" class="btn btn-dark w-100">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="/Mindanow/public/index.php" class="small text-decoration-none">
                            ← Back to Website
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>

</body>
</html>