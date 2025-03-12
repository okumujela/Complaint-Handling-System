<?php include 'includes/header.php'; ?>

<section class="hero bg-dark text-white" style="background: linear-gradient(rgba(0,0,0,0.7), rgba(0,0,0,0.7)), url('assets/img/hero-bg.jpg'); background-size: cover;">
    <div class="container text-center py-5">
        <h1 class="display-4 mb-4">Complaint Management System</h1>
        <div class="cta-buttons">
            <?php if (!is_logged_in()): ?>
                <a href="login.php" class="btn btn-primary btn-lg mx-2">Login</a>
                <a href="register.php" class="btn btn-outline-light btn-lg mx-2">Register</a>
            <?php else: ?>
                <a href="<?= get_user_role() === 'user' ? 'user/dashboard.php' : 'admin/dashboard.php' ?>" 
                   class="btn btn-success btn-lg mx-2">
                   Go to Dashboard
                </a>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>