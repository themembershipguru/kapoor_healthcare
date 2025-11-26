<?php
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../includes/auth.php';
require_role('admin');
include __DIR__ . '/../includes/header.php';

// get counts for dashboard
$patients = $conn->query('SELECT COUNT(*) AS c FROM patients')->fetch_assoc()['c'] ?? 0;
$doctors = $conn->query('SELECT COUNT(*) AS c FROM doctors')->fetch_assoc()['c'] ?? 0;
$appts = $conn->query('SELECT COUNT(*) AS c FROM appointments')->fetch_assoc()['c'] ?? 0;
?>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="#" class="brand-link text-center">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>
  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
        <li class="nav-item">
          <a href="dashboard.php" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="doctors.php" class="nav-link">
            <i class="nav-icon fas fa-user-md"></i><p>Doctors</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="patients.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i><p>Patients</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="appointments.php" class="nav-link">
            <i class="nav-icon fas fa-calendar-check"></i><p>Appointments</p>
          </a>
        </li>
      </ul>
    </nav>
  </div>
</aside>

<div class="content-wrapper">
  <section class="content pt-3">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-4 col-6">
          <div class="small-box bg-info">
            <div class="inner">
              <h3><?php echo $patients; ?></h3>
              <p>Patients</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?php echo $doctors; ?></h3>
              <p>Doctors</p>
            </div>
            <div class="icon"><i class="fas fa-user-md"></i></div>
          </div>
        </div>
        <div class="col-lg-4 col-6">
          <div class="small-box bg-warning">
            <div class="inner">
              <h3><?php echo $appts; ?></h3>
              <p>Appointments</p>
            </div>
            <div class="icon"><i class="far fa-calendar-check"></i></div>
          </div>
        </div>
      </div>

      <div class="row mt-3">
        <div class="col-md-6">
          <h5>Doctors</h5>
          <a href="add_doctor.php" class="btn btn-primary mr-2">Add Doctor</a>
          <a href="doctors.php" class="btn btn-outline-primary">View Doctors</a>
        </div>
        <div class="col-md-6">
          <h5>Patients</h5>
          <a href="add_patient.php" class="btn btn-success mr-2">Add Patient</a>
          <a href="patients.php" class="btn btn-outline-secondary">View Patients</a>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-md-12">
          <h5>Appointments</h5>
          <a href="add_appointment.php" class="btn btn-info mr-2">Add Appointment</a>
          <a href="appointments.php" class="btn btn-outline-success">View Appointments</a>
        </div>
      </div>
    </div>
  </section>
</div>
<?php include __DIR__ . '/../includes/footer.php'; ?>

