<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

$res = $conn->query('
  SELECT d.doctor_id, u.name, u.email, d.specialization
  FROM doctors d
  JOIN users u ON d.user_id = u.user_id
');
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
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Doctors</h3>
        <a href="add_doctor.php" class="btn btn-primary">
          <i class="fas fa-plus"></i> Add Doctor
        </a>
      </div>
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Specialization</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['doctor_id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['specialization']); ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

