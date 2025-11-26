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

$doctors = $conn->query('
  SELECT d.doctor_id, u.name, d.specialization
  FROM doctors d
  JOIN users u ON d.user_id = u.user_id
');

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $doctor_id = (int)($_POST['doctor_id'] ?? 0);
    $date      = $_POST['appointment_date'] ?? '';
    $time      = $_POST['appointment_time'] ?? '';

    // check if slot available
    if ($doctor_id && $date && $time) {
        $stmt2 = $conn->prepare('SELECT appointment_id FROM appointments WHERE doctor_id=? AND appointment_date=? AND appointment_time=?');
        $stmt2->bind_param('iss', $doctor_id, $date, $time);
        $stmt2->execute();
        $exists = $stmt2->get_result()->num_rows;

        if ($exists > 0) {
            $msg = '<div class="alert alert-danger">This slot is already booked. Please choose another.</div>';
        } else {
            $stmt3 = $conn->prepare('INSERT INTO appointments (patient_id, doctor_id, appointment_date, appointment_time) VALUES (?, ?, ?, ?)');
            $stmt3->bind_param('iiss', $patient_id, $doctor_id, $date, $time);
            $stmt3->execute();
            $msg = '<div class="alert alert-success">Appointment booked successfully.</div>';
        }
    } else {
        $msg = '<div class="alert alert-danger">Please fill all details.</div>';
    }
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Patient Panel</span>
  </a>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Book Appointment</h3>
      <?php echo $msg; ?>
      <form method="post" class="card card-body">
        <div class="form-group">
          <label>Doctor</label>
          <select name="doctor_id" class="form-control" required>
            <option value="">Select</option>
            <?php while ($d = $doctors->fetch_assoc()): ?>
              <option value="<?php echo $d['doctor_id']; ?>">
                <?php echo htmlspecialchars($d['name']); ?> (<?php echo htmlspecialchars($d['specialization']); ?>)
              </option>
            <?php endwhile; ?>
          </select>
        </div>
        <div class="form-group">
          <label>Date</label>
          <input type="date" name="appointment_date" class="form-control" required>
        </div>
        <div class="form-group">
          <label>Time</label>
          <input type="time" name="appointment_time" class="form-control" required>
        </div>
        <button class="btn btn-primary mt-2">Book</button>
      </form>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

