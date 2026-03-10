<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    if (!empty($username) && !empty($email) && !empty($password)) {

        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $hashed, $role);
        $stmt->execute();

        header("Location: /Mindanow/admin/users/index.php");
        exit();

    } else {
        $error = "All fields are required.";
    }
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3 class="fw-semibold mb-4">Add New User</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<?php if($error): ?>
    <div class="alert alert-danger small"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="admin">Admin</option>
            <option value="editor">Editor</option>
        </select>
    </div>

    <button type="submit" class="btn btn-dark btn-sm">Save</button>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

</form>

</div>
</div>
</div>

<?php include '../../includes/footer.php'; ?>