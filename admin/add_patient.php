<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = $_POST['name'] ?? '';
    $email   = $_POST['email'] ?? '';
    $pass    = $_POST['password'] ?? '';
    $age     = $_POST['age'] ?? '';
    $gender  = $_POST['gender'] ?? '';
    $contact = $_POST['contact'] ?? '';

    // add patient to database
    if ($name && $email && $pass) {
        $hash = password_hash($pass, PASSWORD_DEFAULT);

        $stmt = $conn->prepare('INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, "patient")');
        $stmt->bind_param('sss', $name, $email, $hash);
        $stmt->execute();
        $user_id = $stmt->insert_id;

        $stmt2 = $conn->prepare('INSERT INTO patients (user_id, age, gender, contact) VALUES (?, ?, ?, ?)');
        $age_int = $age ? (int)$age : null;
        $stmt2->bind_param('iiss', $user_id, $age_int, $gender, $contact);
        $stmt2->execute();

        $msg = '<div class="alert alert-success">Patient added successfully.</div>';
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
        <li class="nav-item"><a href="patients.php" class="nav-link active">
          <i class="nav-icon fas fa-users"></i><p>Patients</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Add Patient</h3>
      <?php echo $msg; ?>
      <form method="post" class="card card-body">
        <div class="form-group">
          <label>Name <span class="text-danger">*</span></label>
          <input type="text" name="name" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Email <span class="text-danger">*</span></label>
          <input type="email" name="email" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Password <span class="text-danger">*</span></label>
          <input type="password" name="password" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Age</label>
          <input type="number" name="age" class="form-control" min="1" max="150">
        </div>
        <div class="form-group">
          <label>Gender</label>
          <select name="gender" class="form-control">
            <option value="">Select</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
          </select>
        </div>
        <div class="form-group">
          <label>Contact</label>
          <input type="text" name="contact" class="form-control" placeholder="Phone number">
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="patients.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

