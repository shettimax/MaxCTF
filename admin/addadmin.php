<?php
session_start();
include 'config.php';

if (!isset($_SESSION['alogin']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $role = !empty($_POST['role']) ? mysqli_real_escape_string($conn, $_POST['role']) : 'admin';

    if ($username && $email && $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $insert = "INSERT INTO admin (username, email, password, role)
                   VALUES ('$username', '$email', '$hashed', '$role')";
        if (mysqli_query($conn, $insert)) {
            $creator = $_SESSION['alogin'];
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$creator','Created new admin $username')");
            $message = "success";
        } else {
            $message = "error";
        }
    } else {
        $message = "incomplete";
    }
}
?>

<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
    <h1 class="mt-4"><i class="fas fa-user-shield"></i> Add New Admin</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Add Admin</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header text-green">Admin Credentials</div>
        <div class="card-body">
            <form method="POST" action="addadmin.php">
                <div class="form-group">
                    <label>Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Role</label>
                    <select name="role" class="form-control">
                        <option value="admin">Admin</option>
                        <option value="superadmin">Superadmin</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Add Admin</button>
            </form>
        </div>
    </div>
</div>
</main>
<?php include 'footer.php'; ?>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if ($message === "success"): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'success',
    title: 'Admin added successfully',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true
});
</script>
<?php elseif ($message === "error"): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'error',
    title: 'Error adding admin',
    text: 'Something went wrong.',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php elseif ($message === "incomplete"): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'warning',
    title: 'Missing fields',
    text: 'Please fill in all required fields.',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php endif; ?>
