<?php
session_start();
unset($_SESSION["id"]);
unset($_SESSION["name"]);
session_destroy($_SESSION['id']);
header("Location:login.php");
?>
