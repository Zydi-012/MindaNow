<?php
require_once '../../Includes/auth.php';
require_once '../../Includes/db.php';
require_once '../../Includes/upload.php';

$id = intval($_GET['id'] ?? 0);
$error = '';

$stmt = $conn->prepare("SELECT * FROM destinations WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$destination = $stmt->get_result()->fetch_assoc();

if (!$destination) {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $location = trim($_POST['location']);
    $description = trim($_POST['description']);
    $category = $_POST['category'];
    $image = $destination['image'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $upload = uploadImage($_FILES['image'], 'destinations');
        if ($upload['success']) {
            if ($image) deleteImage($image);
            $image = $upload['filename'];
        }
    }

    if (!empty($name) && !empty($location)) {
        $stmt = $conn->prepare("UPDATE destinations SET name=?, location=?, description=?, category=?, image=? WHERE id=?");
        $stmt->bind_param("sssssi", $name, $location, $description, $category, $image, $id);
        $stmt->execute();
        header("Location: index.php");
        exit();
    }
}
?>

<?php include '../../Includes/header.php'; ?>

<div class="top-bar">
    <h4 class="mb-0">Edit Destination</h4>
    <a href="index.php" class="btn btn-outline-secondary btn-sm">Back</a>
</div>

<div class="container-fluid">
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($destination['name']); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location *</label>
                        <input type="text" name="location" class="form-control" value="<?php echo htmlspecialchars($destination['location']); ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" rows="4" class="form-control"><?php echo htmlspecialchars($destination['description']); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Category</label>
                        <select name="category" class="form-control">
                            <?php
                            $categories = ['beach', 'mountain', 'cultural', 'nature', 'waterfall', 'city', 'festival'];
                            foreach ($categories as $cat) {
                                $selected = ($cat == $destination['category']) ? 'selected' : '';
                                echo "<option value='$cat' $selected>" . ucfirst($cat) . "</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Image</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <?php if ($destination['image']): ?>
                            <img src="../../<?php echo $destination['image']; ?>" class="mt-2" style="max-width:200px;">
                        <?php endif; ?>
                    </div>
                </div>

                <button type="submit" class="btn btn-dark">Update Destination</button>
                <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>

<?php include '../../Includes/footer.php'; ?>
