<?php
session_start();
include 'config.php';

if (!isset($_SESSION['alogin']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit;
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize inputs
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $role = !empty($_POST['role']) ? trim($_POST['role']) : 'admin';
    
    // Input validation
    if (empty($username) || strlen($username) < 3) {
        $message = "Username must be at least 3 characters";
    } elseif (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Valid email is required";
    } elseif (empty($password) || strlen($password) < 4) {
        $message = "Password must be at least 4 characters";
    } elseif (!in_array($role, array('admin', 'superadmin'))) {
        $message = "Invalid role selected";
    } else {
        $username = mysqli_real_escape_string($conn, $username);
        $email = mysqli_real_escape_string($conn, $email);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        
        // Check if username or email already exists
        $check = mysqli_query($conn, "SELECT idPrimary FROM admin WHERE username='$username' OR email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $message = "duplicate";
        } else {
            $insert = "INSERT INTO admin (username, email, password, role)
                       VALUES ('$username', '$email', '$hashed', '$role')";
            if (mysqli_query($conn, $insert)) {
                $creator = mysqli_real_escape_string($conn, $_SESSION['alogin']);
                $action = "Created new admin $username";
                mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$creator','$action')");
                $message = "success";
            } else {
                $message = "error";
            }
        }
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
                    <input type="text" name="username" class="form-control" required minlength="3" maxlength="50">
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class="form-control" required minlength="4">
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
<?php elseif ($message === "duplicate"): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'warning',
    title: 'Username or email exists',
    text: 'Please choose different credentials.',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php elseif (!empty($message)): ?>
<script>
Swal.fire({
    toast: true,
    position: 'top-end',
    icon: 'warning',
    title: '<?php echo addslashes($message); ?>',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});
</script>
<?php endif; ?>