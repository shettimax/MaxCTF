<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_array($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['alogin'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];
        header('location:dashboard.php');
    } else {
        $error = "Invalid credentials";
    }
}
?>

<form method="POST" action="admin_login.php">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <?php if (isset($error)) echo "<p>$error</p>"; ?>
</form>
