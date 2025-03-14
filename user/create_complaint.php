<?php
require_once '../includes/config.php';
redirect_if_not_logged_in();

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = sanitize_input($_POST['title']);
    $message = sanitize_input($_POST['message']);
    $department = sanitize_input($_POST['department']);
    
    if (empty($title) || empty($message) || empty($department)) {
        $errors[] = "All fields are required";
    }
    
    if (empty($errors)) {
        $stmt = $pdo->prepare("INSERT INTO complaints (user_id, title, message, department) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $title, $message, $department]);
        header("Location: dashboard.php");
        exit();
    }
}

include '../includes/header.php';
?>

<div class="container mt-5">
    <h2>Create New Complaint</h2>
    
    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger"><?= implode('<br>', $errors) ?></div>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Department</label>
            <input type="text" name="department" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea name="message" class="form-control" rows="5" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Complaint</button>
    </form>
</div>

<?php include '../includes/footer.php'; ?>