<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

$res = $conn->query("
  SELECT a.*, u1.name AS patient_name, u2.name AS doctor_name
  FROM appointments a
  JOIN patients p ON a.patient_id = p.patient_id
  JOIN doctors d ON a.doctor_id = d.doctor_id
  JOIN users u1 ON p.user_id = u1.user_id
  JOIN users u2 ON d.user_id = u2.user_id
  ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
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
        <li class="nav-item"><a href="appointments.php" class="nav-link active">
          <i class="nav-icon fas fa-calendar-check"></i><p>Appointments</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Appointments</h3>
        <a href="add_appointment.php" class="btn btn-info">
          <i class="fas fa-plus"></i> Add Appointment
        </a>
      </div>
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>ID</th><th>Date</th><th>Time</th><th>Patient</th><th>Doctor</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $res->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['appointment_id']; ?></td>
            <td><?php echo $row['appointment_date']; ?></td>
            <td><?php echo substr($row['appointment_time'], 0, 5); ?></td>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($row['doctor_name']); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

