<?php
ob_start();
session_start();
include 'config.php';

if (isset($_SESSION['alogin']) && strlen($_SESSION['alogin']) != 0) {
    header('location:dashboard.php');
    exit;
}

$error = '';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['name']);
    $password = $_POST['password'];

    $query = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username'");
    $admin = mysqli_fetch_array($query);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['alogin'] = $admin['username'];
        $_SESSION['role'] = $admin['role'];
        $_SESSION['last_activity'] = time();
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$username','Logged in')");
        header('location:dashboard.php');
        exit;
    } else {
        $error = "Invalid username or password";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-dark text-green">
    <div class="container">
        <div class="login-box mt-5">
            <h2 class="text-center mb-4">CTFBACKBOX 💀</h2>
            <form method="post" class="card p-4 bg-black border-green">
                <label>Username</label>
                <input type="text" name="name" class="form-control mb-3" required>
                <label>Password</label>
                <input type="password" name="password" class="form-control mb-3" required>
                <button type="submit" name="login" class="btn btn-success w-100">Login</button>
            </form>
        </div>
    </div>

    <?php if ($error || isset($_GET['timeout'])): ?>
    <script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: '<?php echo isset($_GET['timeout']) ? "info" : "error"; ?>',
        title: '<?php echo isset($_GET['timeout']) ? "Session expired" : $error; ?>',
        text: '<?php echo isset($_GET['timeout']) ? "Please log in again." : ""; ?>',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
    </script>
    <?php endif; ?>
</body>
</html>
