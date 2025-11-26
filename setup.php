<?php
// database setup script
require_once __DIR__ . '/config.php';

$error = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = $_POST['db_host'] ?? '';
    $user = $_POST['db_user'] ?? '';
    $pass = $_POST['db_pass'] ?? '';
    $name = $_POST['db_name'] ?? '';

    // Handle empty password (common for local MySQL)
    // mysqli accepts empty string for no password, but we'll use it as-is
    $conn = @new mysqli($host, $user, $pass);
    if ($conn->connect_error) {
        $error = "Connection failed: " . $conn->connect_error . "<br><br>";
        $error .= "<strong>Common solutions:</strong><br>";
        $error .= "1. Leave password field <strong>empty</strong> if MySQL root has no password<br>";
        $error .= "2. Make sure MySQL is running<br>";
        $error .= "3. Try common passwords like 'root' or check your MySQL setup";
    } else {
        if (!$conn->query("CREATE DATABASE IF NOT EXISTS `$name`")) {
            $error = "Could not create database: " . $conn->error;
        } else {
            $conn->select_db($name);
            $sql = file_get_contents(__DIR__ . '/sql/schema.sql');
            if (!$sql) {
                $error = "Could not read sql/schema.sql";
            } else {
                if ($conn->multi_query($sql)) {
                    $success = true;
                } else {
                    $error = "Error running schema.sql: " . $conn->error;
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Kapoor Healthcare Setup</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
  <h3>Kapoor Healthcare - Setup</h3>
  <p class="text-muted">Enter MySQL details to setup database and create admin user.</p>

  <?php if ($error): ?>
    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
  <?php elseif ($success): ?>
    <div class="alert alert-success">
      Setup completed. Now you can <a href="index.php">login</a> as:<br>
      admin@kapoorhealthcare.com / admin123
      <br><br><strong>Delete setup.php after successful setup for security.</strong>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="form-group">
      <label>DB Host</label>
      <input type="text" name="db_host" class="form-control" value="localhost" required>
    </div>
    <div class="form-group">
      <label>DB User</label>
      <input type="text" name="db_user" class="form-control" value="root" required>
    </div>
    <div class="form-group">
      <label>DB Password</label>
      <input type="password" name="db_pass" class="form-control" placeholder="Leave empty if no password set">
      <small class="form-text text-muted">On Mac, MySQL root often has no password - leave this empty</small>
    </div>
    <div class="form-group">
      <label>DB Name</label>
      <input type="text" name="db_name" class="form-control" value="kapoor_healthcare" required>
    </div>
    <button class="btn btn-primary">Run Setup</button>
  </form>
</div>
</body>
</html>

