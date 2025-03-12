<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Complaint Management System</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="../index.php">CMS</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <?php if (is_logged_in()): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= get_user_role() === 'user' ? 'user/dashboard.php' : 'admin/dashboard.php' ?>">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">Logout</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../login.php">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../register.php">Register</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>