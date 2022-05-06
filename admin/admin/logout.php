<?php
session_start(); 

unset($_SESSION['alogin']);
session_destroy($_SESSION['alogin']);
header("location:index.php"); 
?>

