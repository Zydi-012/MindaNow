<?php
require_once '../../Includes/auth.php';
require_once '../../Includes/db.php';
require_once '../../Includes/upload.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    $image = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload = uploadImage($_FILES['image'], 'destinations');
        if ($upload['success']) {
            $image = $upload['filename'];
        } else {
            $error = $upload['message'];
        }
    }

    if (empty($error) && !empty($name) && !empty($location)) {
        $stmt = $conn->prepare("INSERT INTO destinations (name, location, description, category, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $name, $location, $description, $category, $image);
        $stmt->execute();
        header("Location: index.php");
        exit();
    } elseif (empty($error)) {
        $error = "Name and Location are required.";
    }
}
?>

<?php include '../../Includes/header.php'; ?>

<div class="top-bar">
    <h4 class="mb-0">Add Destination</h4>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Back
    </a>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <?php if ($error): ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <option value="beach">Beach</option>
                            <option value="mountain">Mountain</option>
                            <option value="cultural">Cultural</option>
                            <option value="nature">Nature</option>
                            <option value="waterfall">Waterfall</option>
                            <option value="city">City</option>
                            <option value="festival">Festival</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>
                </div>

                <button type="submit" class="btn btn-dark">Save Destination</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../Includes/footer.php'; ?>
