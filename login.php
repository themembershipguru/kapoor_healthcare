<?php
session_start();
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/config.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

if (!$email || !$password) {
    header('Location: ' . BASE_URL . 'index.php?msg=invalid');
    exit;
}

// check user credentials
$stmt = $conn->prepare('SELECT user_id, name, password, role FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['name'] = $user['name'];
    $_SESSION['role'] = $user['role'];

    // redirect based on role
    if ($user['role'] === 'admin') {
        header('Location: ' . BASE_URL . 'admin/dashboard.php');
    } elseif ($user['role'] === 'doctor') {
        header('Location: ' . BASE_URL . 'doctor/dashboard.php');
    } else {
        header('Location: ' . BASE_URL . 'patient/dashboard.php');
    }
    exit;
} else {
    header('Location: ' . BASE_URL . 'index.php?msg=invalid');
    exit;
}
