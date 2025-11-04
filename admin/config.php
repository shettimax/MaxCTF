<?php
// Prevent multiple inclusions
if (!defined('CONFIG_LOADED')) {
    define('CONFIG_LOADED', true);
    
    // Disable error displaying in production
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $host = "127.0.0.1"; 
    $user = "root"; 
    $pass = "kir@1337"; 
    $db = "ctf2"; 

    $conn = mysqli_connect($host, $user, $pass);
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error());
        die("Database connection failed");
    }

    if (!mysqli_select_db($conn, $db)) {
        error_log("Database selection failed: " . mysqli_error($conn));
        die("Database selection failed");
    }

    // CSRF protection functions
    function generate_csrf_token() {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = md5(uniqid(mt_rand(), true));
        }
        return $_SESSION['csrf_token'];
    }

    function validate_csrf_token($token) {
        return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $token;
    }

    // Input validation functions
    function sanitize_input($data) {
        if (is_array($data)) {
            return array_map('sanitize_input', $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    function validate_email($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    function validate_username($username) {
        return preg_match('/^[a-zA-Z0-9_]{3,50}$/', $username);
    }
}
?>