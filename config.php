<?php
// database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', ''); // leave empty if no password
define('DB_NAME', 'kapoor_healthcare');

// base url for redirects and links
$script_name = $_SERVER['SCRIPT_NAME'];
if (strpos($script_name, '/admin/') !== false || strpos($script_name, '/doctor/') !== false || strpos($script_name, '/patient/') !== false) {
    $script_dir = dirname(dirname($script_name));
} else {
    $script_dir = dirname($script_name);
}

if ($script_dir === '/' || $script_dir === '\\' || $script_dir === '.') {
    define('BASE_URL', '/');
} else {
    define('BASE_URL', rtrim($script_dir, '/') . '/');
}

