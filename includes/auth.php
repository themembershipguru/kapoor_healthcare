<?php
// authentication functions
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: ' . BASE_URL . 'index.php?msg=login_required');
        exit;
    }
}

function require_role($role) {
    require_login();
    if ($_SESSION['role'] !== $role) {
        http_response_code(403);
        echo "Access denied.";
        exit;
    }
}

