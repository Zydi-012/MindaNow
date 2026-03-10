<?php
require_once '../../includes/auth.php';
require_once '../../includes/db.php';

$id = intval($_GET['id']);

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if(!$user){
    header("Location: index.php");
    exit();
}

$error = '';

if($_SERVER['REQUEST_METHOD']=='POST'){
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];

    if(!empty($_POST['password'])){
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET username=?, email=?, password=?, role=? WHERE id=?");
        $update->bind_param("ssssi", $username, $email, $password, $role, $id);
    } else {
        $update = $conn->prepare("UPDATE users SET username=?, email=?, role=? WHERE id=?");
        $update->bind_param("sssi", $username, $email, $role, $id);
    }

    $update->execute();
    header("Location: index.php");
    exit();
}
?>

<?php include '../../includes/header.php'; ?>

<div class="container py-5">

<h3 class="fw-semibold mb-4">Edit User</h3>

<div class="card border-0 shadow-sm">
<div class="card-body">

<?php if($error): ?>
<div class="alert alert-danger small"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST">

    <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required>
    </div>

    <div class="mb-3">
        <label class="form-label">Password <small>(Leave blank to keep current)</small></label>
        <input type="password" name="password" class="form-control">
    </div>

    <div class="mb-3">
        <label class="form-label">Role</label>
        <select name="role" class="form-select">
            <option value="admin" <?php if($user['role']=='admin') echo 'selected'; ?>>Admin</option>
            <option value="editor" <?php if($user['role']=='editor') echo 'selected'; ?>>Editor</option>
        </select>
    </div>

    <button type="submit" class="btn btn-dark btn-sm">Update</button>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">Cancel</a>

</form>

</div>
</div>
</div>

<?php include '../../includes/footer.php'; ?>