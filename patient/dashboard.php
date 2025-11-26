<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('patient');
include __DIR__ . '/../includes/header.php';

$uid = $_SESSION['user_id'];

$stmt = $conn->prepare('SELECT patient_id FROM patients WHERE user_id = ?');
$stmt->bind_param('i', $uid);
$stmt->execute();
$pat = $stmt->get_result()->fetch_assoc();
$patient_id = $pat['patient_id'] ?? 0;

$stmt2 = $conn->prepare("
  SELECT a.*, u.name AS doctor_name
  FROM appointments a
  JOIN doctors d ON a.doctor_id = d.doctor_id
  JOIN users u ON d.user_id = u.user_id
  WHERE a.patient_id = ?
  ORDER BY a.appointment_date DESC, a.appointment_time DESC
");
$stmt2->bind_param('i', $patient_id);
$stmt2->execute();
$appts = $stmt2->get_result();
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Patient Panel</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link active">
          <i class="nav-icon fas fa-home"></i><p>Dashboard</p></a></li>
        <li class="nav-item"><a href="book_appointment.php" class="nav-link">
          <i class="nav-icon fas fa-calendar-plus"></i><p>Book Appointment</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Your Appointments</h3>
      <a href="book_appointment.php" class="btn btn-primary mb-3">Book New Appointment</a>
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Date</th><th>Time</th><th>Doctor</th><th>Status</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $appts->fetch_assoc()): ?>
          <tr>
            <td><?php echo $row['appointment_date']; ?></td>
            <td><?php echo substr($row['appointment_time'], 0, 5); ?></td>
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

