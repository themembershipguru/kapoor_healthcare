<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $pass = $_POST['password'] ?? '';
    $spec = $_POST['specialization'] ?? '';

    // add doctor to database
    if ($name && $email && $pass) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, "doctor")');
        $stmt->bind_param('sss', $name, $email, $hash);
        $stmt->execute();
        $user_id = $stmt->insert_id;

        $stmt2 = $conn->prepare('INSERT INTO doctors (user_id, specialization) VALUES (?, ?)');
        $stmt2->bind_param('is', $user_id, $spec);
        $stmt2->execute();

        $msg = '<div class="alert alert-success">Doctor added successfully.</div>';
    } else {
        $msg = '<div class="alert alert-danger">Please fill all required fields.</div>';
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link">
          <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="doctors.php" class="nav-link active">
          <i class="nav-icon fas fa-user-md"></i><p>Doctors</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Add Doctor</h3>
      <?php echo $msg; ?>
      <form method="post" class="card card-body">
        <div class="form-group">
          <label>Name</label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email</label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Specialization</label>
          <input type="text" name="specialization" class="form-control">
        </div>
        <button class="btn btn-primary">Save</button>
      </form>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

