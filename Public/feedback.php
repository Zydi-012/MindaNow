<?php
session_start();
require_once __DIR__ . '/../Includes/db.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $message = trim($_POST['message'] ?? '');
    
    if (empty($message)) {
        $error = "Message is required.";
    } elseif (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);
        
        if ($stmt->execute()) {
            header("Location: feedback.php?success=1");
            exit();
        } else {
            $error = "Failed to submit feedback. Please try again later.";
        }
    }
}

if (isset($_GET['success'])) {
    $success = "Thank you for your feedback! We'll get back to you soon.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback - MindaNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --accent-color: #f59e0b;
        }
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .navbar-brand { 
            font-weight: 700; 
            background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .feedback-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body class="d-flex align-items-center py-5">

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                
                <div class="text-center mb-4">
                    <a href="index.php" class="navbar-brand fs-2 text-white text-decoration-none">
                        <i class="fas fa-brain"></i> MindaNow
                    </a>
                </div>

                <div class="card feedback-card border-0">
                    <div class="card-body p-4 p-md-5">
                        
                        <h2 class="mb-4 text-center">
                            <i class="fas fa-comments text-primary"></i> Send Us Feedback
                        </h2>

                        <?php if (!empty($success)): ?>
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle"></i> <?php echo htmlspecialchars($success); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST" action="">
                            
                            <div class="mb-3">
                                <label for="name" class="form-label">Your Name (optional)</label>
                                <input 
                                    type="text" 
                                    name="name" 
                                    id="name" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($_POST['name'] ?? ''); ?>" 
                                    maxlength="100" 
                                    placeholder="John Doe"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email (optional)</label>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email" 
                                    class="form-control" 
                                    value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>" 
                                    maxlength="100" 
                                    placeholder="john@example.com"
                                >
                            </div>

                            <div class="mb-3">
                                <label for="message" class="form-label">Message <span class="text-danger">*</span></label>
                                <textarea 
                                    name="message" 
                                    id="message" 
                                    class="form-control" 
                                    rows="5" 
                                    required 
                                    placeholder="Your feedback here..."
                                ><?php echo htmlspecialchars($_POST['message'] ?? ''); ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 mb-2">
                                <i class="fas fa-paper-plane"></i> Send Feedback
                            </button>

                            <a href="index.php" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-home"></i> Back to Home
                            </a>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
