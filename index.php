<?php
session_start();
require_once __DIR__ . '/config.php';

if (!empty($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin')  header('Location: ' . BASE_URL . 'admin/dashboard.php');
    if ($_SESSION['role'] === 'doctor') header('Location: ' . BASE_URL . 'doctor/dashboard.php');
    if ($_SESSION['role'] === 'patient')header('Location: ' . BASE_URL . 'patient/dashboard.php');
    exit;
}
$msg = $_GET['msg'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kapoor Healthcare - Login</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <b>Kapoor</b> Healthcare
  </div>
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <?php if ($msg === 'invalid'): ?>
        <div class="alert alert-danger">Invalid email or password.</div>
      <?php elseif ($msg === 'login_required'): ?>
        <div class="alert alert-warning">Please login to continue.</div>
      <?php endif; ?>

      <form action="<?php echo BASE_URL; ?>login.php" method="post">
        <div class="input-group mb-3">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-envelope"></span></div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
          <div class="input-group-append">
            <div class="input-group-text"><span class="fas fa-lock"></span></div>
          </div>
        </div>
        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
          </div>
        </div>
      </form>

      <p class="mt-3 mb-0 text-muted text-sm">
        Default login: admin@kapoorhealthcare.com / admin123
      </p>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>

