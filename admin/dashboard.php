<?php
require_once '../includes/config.php';
redirect_if_not_logged_in();
if (!in_array(get_user_role(), ['super_admin', 'manager'])) {
    header("Location: ../user/dashboard.php");
    exit();
}

include '../includes/header.php';

// Dashboard Stats
$stmt = $pdo->query("SELECT COUNT(*) FROM complaints");
$total_complaints = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM complaints WHERE status = 'resolved'");
$resolved = $stmt->fetchColumn();

$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$total_users = $stmt->fetchColumn();
?>
<div class="container mt-5">
    <h2 class="mb-4">Admin Dashboard</h2>
    
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Complaints</h5>
                    <h2><?= $total_complaints ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Resolved</h5>
                    <h2><?= $resolved ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card bg-warning text-dark">
                <div class="card-body">
                    <h5 class="card-title">Total Users</h5>
                    <h2><?= $total_users ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    Quick Actions
                </div>
                <div class="card-body">
                    <a href="manage_users.php" class="btn btn-primary">Manage Users</a>
                    <a href="manage_complaints.php" class="btn btn-success">Manage Complaints</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../includes/footer.php'; ?>