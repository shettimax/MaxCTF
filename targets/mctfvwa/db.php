<?php
$host = "127.0.0.1";
$user = "root";
$pass = "kir@1337";
$db   = "mctfvwadb";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

// Optional debug toggle
$debug = false;
if ($debug) {
  ini_set('display_errors', 1);
  error_reporting(E_ALL);
} else {
  ini_set('display_errors', 0);
}
?>
