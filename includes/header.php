<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Kapoor Healthcare</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- AdminLTE + Bootstrap + Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button">
        <i class="fas fa-bars"></i>
      </a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="<?php echo BASE_URL; ?>index.php" class="nav-link">Kapoor Healthcare</a>
    </li>
  </ul>
  <ul class="navbar-nav ml-auto">
    <?php if (!empty($_SESSION['name'])): ?>
      <li class="nav-item">
        <span class="nav-link">
          <i class="far fa-user"></i>
          <?php echo htmlspecialchars($_SESSION['name']); ?>
          (<?php echo htmlspecialchars($_SESSION['role']); ?>)
        </span>
      </li>
      <li class="nav-item">
        <a href="<?php echo BASE_URL; ?>logout.php" class="nav-link text-danger">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
      </li>
    <?php endif; ?>
  </ul>
</nav>
<!-- /.navbar -->

