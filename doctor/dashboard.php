<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('doctor');
include __DIR__ . '/../includes/header.php';

$uid = $_SESSION['user_id'];

$stmt = $conn->prepare('SELECT doctor_id FROM doctors WHERE user_id = ?');
$stmt->bind_param('i', $uid);
$stmt->execute();
$doc = $stmt->get_result()->fetch_assoc();
$doctor_id = $doc['doctor_id'] ?? 0;

$today = date('Y-m-d');
$stmt2 = $conn->prepare("
  SELECT a.appointment_id, a.appointment_time, u.name AS patient_name
  FROM appointments a
  JOIN patients p ON a.patient_id = p.patient_id
  JOIN users u ON p.user_id = u.user_id
  WHERE a.doctor_id = ? AND a.appointment_date = ?
  ORDER BY a.appointment_time
");
$stmt2->bind_param('is', $doctor_id, $today);
$stmt2->execute();
$appts = $stmt2->get_result();
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Doctor Panel</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item"><a href="dashboard.php" class="nav-link active">
          <i class="nav-icon fas fa-calendar-day"></i><p>Today's Appointments</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Today's Appointments (<?php echo htmlspecialchars($today); ?>)</h3>
      <table class="table table-striped table-sm">
        <thead>
          <tr>
            <th>Time</th><th>Patient</th><th>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php while ($row = $appts->fetch_assoc()): ?>
          <tr>
            <td><?php echo substr($row['appointment_time'], 0, 5); ?></td>
            <td><?php echo htmlspecialchars($row['patient_name']); ?></td>
            <td>
              <a href="visit.php?appointment_id=<?php echo $row['appointment_id']; ?>" class="btn btn-xs btn-primary">
                Add Visit / Prescription
              </a>
            </td>
          </tr>
        <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

