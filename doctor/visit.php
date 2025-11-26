<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('doctor');
include __DIR__ . '/../includes/header.php';

$appointment_id = (int)($_GET['appointment_id'] ?? 0);
$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $symptoms = $_POST['symptoms'] ?? '';
    $diagnosis = $_POST['diagnosis'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $med_name = $_POST['medicine_name'] ?? '';
    $dosage = $_POST['dosage'] ?? '';
    $duration = $_POST['duration'] ?? '';
    $freq = $_POST['frequency'] ?? '';

    $stmt = $conn->prepare('INSERT INTO visits (appointment_id, symptoms, diagnosis, notes) VALUES (?, ?, ?, ?)');
    $stmt->bind_param('isss', $appointment_id, $symptoms, $diagnosis, $notes);
    $stmt->execute();
    $visit_id = $stmt->insert_id;

    if ($med_name) {
        $stmt2 = $conn->prepare('INSERT INTO prescriptions (visit_id, medicine_name, dosage, duration, frequency) VALUES (?, ?, ?, ?, ?)');
        $stmt2->bind_param('issss', $visit_id, $med_name, $dosage, $duration, $freq);
        $stmt2->execute();
    }

    $msg = '<div class="alert alert-success">Visit and prescription saved.</div>';
}
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Doctor Panel</span>
  </a>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <h3>Visit Details & Prescription</h3>
      <?php echo $msg; ?>
      <form method="post" class="card card-body">
        <div class="form-group">
          <label>Symptoms</label>
          <textarea name="symptoms" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label>Diagnosis</label>
          <textarea name="diagnosis" class="form-control" rows="3"></textarea>
        </div>
        <div class="form-group">
          <label>Notes</label>
          <textarea name="notes" class="form-control" rows="3"></textarea>
        </div>
        <hr>
        <h5>Prescription</h5>
        <div class="form-group">
          <label>Medicine Name</label>
          <input type="text" name="medicine_name" class="form-control">
        </div>
        <div class="form-group">
          <label>Dosage</label>
          <input type="text" name="dosage" class="form-control">
        </div>
        <div class="form-group">
          <label>Duration</label>
          <input type="text" name="duration" class="form-control">
        </div>
        <div class="form-group">
          <label>Frequency</label>
          <input type="text" name="frequency" class="form-control">
        </div>
        <button class="btn btn-primary mt-2">Save Visit & Prescription</button>
      </form>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

