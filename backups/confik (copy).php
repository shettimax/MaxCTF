<?php 
$host = "localhost"; 
$user = "root"; 
$pass = ""; 
$db = "ctf"; 
$conn = mysqli_connect($host, $user, $pass);
mysqli_select_db($conn,$db);

$con= new mysqli('localhost','root','','ctf')or die("Could not connect to mysql".mysqli_error($con));

?>
