<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

$patients_result = $conn->query('
  SELECT p.patient_id, u.name
  FROM patients p
  JOIN users u ON p.user_id = u.user_id
  ORDER BY u.name
');
$patients_list = [];
while ($p = $patients_result->fetch_assoc()) {
    $patients_list[] = $p;
}

$doctors_result = $conn->query('
  SELECT d.doctor_id, u.name, d.specialization
  FROM doctors d
  JOIN users u ON d.user_id = u.user_id
  ORDER BY u.name
');
$doctors_list = [];
while ($d = $doctors_result->fetch_assoc()) {
    $doctors_list[] = $d;
}

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = (int)($_POST['patient_id'] ?? 0);
    $doctor_id  = (int)($_POST['doctor_id'] ?? 0);
    $date       = $_POST['appointment_date'] ?? '';
    $time       = $_POST['appointment_time'] ?? '';
    $status     = $_POST['status'] ?? 'Pending';

    // check if all fields filled
    if ($patient_id && $doctor_id && $date && $time) {
        // check if time slot available
        $stmt = $conn->prepare('SELECT appointment_id FROM appointments WHERE doctor_id=? AND appointment_date=? AND appointment_time=?');
        $stmt->bind_param('iss', $doctor_id, $date, $time);
        $stmt->execute();
        $exists = $stmt->get_result()->num_rows;

        if ($exists) {
            $msg = '<div class="alert alert-danger">This slot is already booked. Please choose another time.</div>';
        } else {
            $stmt2 = $conn->prepare('INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time, status) VALUES (?, ?, ?, ?, ?)');
            $stmt2->bind_param('iisss', $patient_id, $doctor_id, $date, $time, $status);
            $stmt2->execute();
            $msg = '<div class="alert alert-success">Appointment created successfully.</div>';
        }
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
        <li class="nav-item"><a href="appointments.php" class="nav-link active">
          <i class="nav-icon fas fa-calendar-check"></i><p>Appointments</p></a></li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Add Appointment</h3>
      <?php echo $msg; ?>
      <form method="post" class="card card-body">
        <div class="form-group">
          <label>Patient <span class="text-danger">*</span></label>
          <select name="patient_id" class="form-control" required>
            <option value="">Select Patient</option>
            <?php foreach ($patients_list as $p): ?>
              <option value="<?php echo $p['patient_id']; ?>">
                <?php echo htmlspecialchars($p['name']); ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Doctor <span class="text-danger">*</span></label>
          <select name="doctor_id" class="form-control" required>
            <option value="">Select Doctor</option>
            <?php foreach ($doctors_list as $d): ?>
              <option value="<?php echo $d['doctor_id']; ?>">
                <?php echo htmlspecialchars($d['name']); ?> 
                <?php if ($d['specialization']): ?>
                  (<?php echo htmlspecialchars($d['specialization']); ?>)
                <?php endif; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Date <span class="text-danger">*</span></label>
          <input type="date" name="appointment_date" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Time <span class="text-danger">*</span></label>
          <input type="time" name="appointment_time" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Status</label>
          <select name="status" class="form-control">
            <option value="Pending">Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>
        <button class="btn btn-primary">Save</button>
        <a href="appointments.php" class="btn btn-secondary">Cancel</a>
      </form>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

