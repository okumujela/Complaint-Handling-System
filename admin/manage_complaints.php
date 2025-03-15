<?php
require_once '../includes/config.php';
redirect_if_not_logged_in();

if (!in_array(get_user_role(), ['super_admin', 'manager'])) {
    header("Location: ../user/dashboard.php");
    exit();
}

// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $complaint_id = $_POST['complaint_id'];
    $status = $_POST['status'];
    
    $stmt = $pdo->prepare("UPDATE complaints SET status = ? WHERE id = ?");
    $stmt->execute([$status, $complaint_id]);
}

// Get all complaints
$stmt = $pdo->query("SELECT * FROM complaints");
$complaints = $stmt->fetchAll();

// Get managers for assignment
$managers = $pdo->query("SELECT * FROM users WHERE role IN ('manager', 'super_admin')")->fetchAll();

include '../includes/header.php';
?>

<div class="container mt-5">
    <h2>Manage Complaints</h2>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Assigned To</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complaints as $complaint): ?>
            <tr>
                <td><?= htmlspecialchars($complaint['title']) ?></td>
                <td>
                    <form method="POST" class="status-form">
                        <input type="hidden" name="complaint_id" value="<?= $complaint['id'] ?>">
                        <select name="status" class="form-control" onchange="this.form.submit()">
                            <option value="pending" <?= $complaint['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="in_progress" <?= $complaint['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                            <option value="resolved" <?= $complaint['status'] === 'resolved' ? 'selected' : '' ?>>Resolved</option>
                        </select>
                    </form>
                </td>
                <td>
                    <select class="form-control assign-select" data-complaint-id="<?= $complaint['id'] ?>">
                        <?php foreach ($managers as $manager): ?>
                        <option value="<?= $manager['id'] ?>" 
                            <?= $complaint['assigned_to'] == $manager['id'] ? 'selected' : '' ?>>
                            <?= $manager['name'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </td>
                <td>
                    <a href="edit_complaint.php?id=<?= $complaint['id'] ?>" class="btn btn-sm btn-info">Edit</a>
                    <button class="btn btn-sm btn-danger delete-complaint" data-id="<?= $complaint['id'] ?>">Delete</button>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $('.assign-select').change(function() {
        const complaintId = $(this).data('complaint-id');
        const managerId = $(this).val();
        
        $.post('assign_complaint.php', {
            complaint_id: complaintId,
            manager_id: managerId
        }, function(response) {
            console.log('Assignment updated');
        });
    });
});
</script>

<?php include '../includes/footer.php'; ?>