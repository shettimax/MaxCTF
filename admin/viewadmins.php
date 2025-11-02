<?php
session_start();
include 'config.php';

if (!isset($_SESSION['alogin']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit;
}

// Handle edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'edit') {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    mysqli_query($conn, "UPDATE admin SET username='$username', email='$email', role='$role' WHERE idPrimary='$id'");
    mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('{$_SESSION['alogin']}','Edited admin $username')");
    exit;
}

// Handle delete
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'delete') {
    $id = $_POST['id'];
    $admin = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM admin WHERE idPrimary='$id'"));
    mysqli_query($conn, "DELETE FROM admin WHERE idPrimary='$id'");
    mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('{$_SESSION['alogin']}','Deleted admin {$admin['username']}')");
    exit;
}

// Fetch admins
$admins = mysqli_query($conn, "SELECT * FROM admin");
?>

<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
    <h1 class="mt-4"><i class="fas fa-user-shield"></i> Admin Users</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active">View Admins</li>
    </ol>

    <div class="card mb-4">
        <div class="card-header text-green">Manage Admin Accounts</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-green" id="adminTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($admins)) { ?>
                        <tr data-id="<?php echo $row['idPrimary']; ?>">
                            <td>
                                <input type="text" class="form-control username" value="<?php echo htmlentities($row['username']); ?>">
                            </td>
                            <td>
                                <input type="text" class="form-control email" value="<?php echo htmlentities($row['email']); ?>">
                            </td>
                            <td>
                                <select class="form-control role">
                                    <option value="admin" <?php if ($row['role'] === 'admin') echo 'selected'; ?>>admin</option>
                                    <option value="superadmin" <?php if ($row['role'] === 'superadmin') echo 'selected'; ?>>superadmin</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-success btn-sm edit">Save</button>
                                <button class="btn btn-danger btn-sm delete ml-2">Delete</button>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</main>
<?php include 'footer2.php'; ?>

<!-- DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function () {
    $('#adminTable').DataTable({
        pageLength: 25,
        responsive: true
    });

    $('.edit').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const username = row.find('.username').val();
        const email = row.find('.email').val();
        const role = row.find('.role').val();

        $.post('viewadmins.php', {
            action: 'edit',
            id: id,
            username: username,
            email: email,
            role: role
        }).done(function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Admin updated',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }).fail(function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Update failed',
                text: 'Could not update admin.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    });

    $('.delete').on('click', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');

        Swal.fire({
            title: 'Delete this admin?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('viewadmins.php', {
                    action: 'delete',
                    id: id
                }).done(function () {
                    row.remove();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'Admin deleted',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                }).fail(function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Delete failed',
                        text: 'Could not delete admin.',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                });
            }
        });
    });
});
</script>
