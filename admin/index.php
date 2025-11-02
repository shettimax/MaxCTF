<?php
ob_start();
session_start();
include 'config.php';

if(isset($_SESSION['alogin']) && strlen($_SESSION['alogin']) != 0){
    header('location:dashboard.php');
}

if (isset($_POST['login'])){
    $username = $_POST['name'];
    $password = $_POST['password'];
    $query = "SELECT * FROM admin WHERE username='$username' and password='$password'";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    if (mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $_SESSION['alogin'] = $username;
        $_SESSION['role'] = $row['role'];
        header('Location:dashboard.php');
    } else {
        header('Location:index.php');
    }
}
ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>💀 Admin Login</title>
    <link href="../css/hacker.css" rel="stylesheet" />
    <link href="../css/alert.css" rel="stylesheet" />
</head>
<body class="bg-dark text-green">
    <div class="container">
        <div class="login-box">
            <h2>CTFBACKBOX 💀</h2>
            <form method="post">
                <label>Username</label>
                <input type="text" name="name" required>
                <label>Password</label>
                <input type="password" name="password" required>
                <button type="submit" name="login" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</body>
</html>
