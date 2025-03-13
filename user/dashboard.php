<?php
require_once '../includes/config.php';
redirect_if_not_logged_in();

include '../includes/header.php';

// User-specific complaints
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM complaints WHERE user_id = ?");
$stmt->execute([$user_id]);
$complaints = $stmt->fetchAll();
?>

<div class="container mt-5">
    <h2>Your Complaints</h2>
    
    <a href="create_complaint.php" class="btn btn-primary mb-3">New Complaint</a>
    
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Title</th>
                <th>Status</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($complaints as $complaint): ?>
            <tr>
                <td><?= htmlspecialchars($complaint['title']) ?></td>
                <td>
                    <span class="badge badge-<?= 
                        $complaint['status'] === 'resolved' ? 'success' : 
                        ($complaint['status'] === 'in_progress' ? 'warning' : 'danger') 
                    ?>">
                        <?= ucfirst(str_replace('_', ' ', $complaint['status'])) ?>
                    </span>
                </td>
                <td><?= date('M d, Y', strtotime($complaint['created_at'])) ?></td>
                <td>
                    <a href="view_complaint.php?id=<?= $complaint['id'] ?>" class="btn btn-sm btn-info">View</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../includes/footer.php'; ?>