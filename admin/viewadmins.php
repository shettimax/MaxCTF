<?php
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (!isset($_SESSION['alogin']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit;
}

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $role = mysqli_real_escape_string($conn, $_POST['role']);
        
        // Validate inputs
        if ($id > 0 && !empty($username) && !empty($email) && in_array($role, array('admin', 'superadmin'))) {
            // Check if username already exists (excluding current admin)
            $check = mysqli_query($conn, "SELECT idPrimary FROM admin WHERE username='$username' AND idPrimary != '$id'");
            if (mysqli_num_rows($check) > 0) {
                echo "username_exists";
                exit;
            }
            
            // Check if email already exists (excluding current admin)
            $check = mysqli_query($conn, "SELECT idPrimary FROM admin WHERE email='$email' AND idPrimary != '$id'");
            if (mysqli_num_rows($check) > 0) {
                echo "email_exists";
                exit;
            }
            
            $result = mysqli_query($conn, "UPDATE admin SET username='$username', email='$email', role='$role' WHERE idPrimary='$id'");
            if ($result) {
                $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
                $action = "Edited admin $username";
                mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "invalid_data";
        }
        exit;
    }

    if ($_POST['action'] === 'delete') {
        $id = intval($_POST['id']);
        if ($id > 0) {
            // Prevent deleting own account
            $current_admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $check_self = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM admin WHERE idPrimary='$id'"));
            
            if ($check_self['username'] === $current_admin) {
                echo "self_delete";
                exit;
            }
            
            $admin = mysqli_fetch_array(mysqli_query($conn, "SELECT username FROM admin WHERE idPrimary='$id'"));
            $username = mysqli_real_escape_string($conn, $admin['username']);
            $result = mysqli_query($conn, "DELETE FROM admin WHERE idPrimary='$id'");
            if ($result) {
                mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$current_admin','Deleted admin $username')");
                echo "success";
            } else {
                echo "error";
            }
        } else {
            echo "invalid_id";
        }
        exit;
    }
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
                        <tr data-id="<?php echo intval($row['idPrimary']); ?>">
                            <td>
                                <span class="username-text"><?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <input type="text" class="form-control username-input d-none" value="<?php echo htmlspecialchars($row['username'], ENT_QUOTES, 'UTF-8'); ?>">
                            </td>
                            <td>
                                <span class="email-text"><?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <input type="email" class="form-control email-input d-none" value="<?php echo htmlspecialchars($row['email'], ENT_QUOTES, 'UTF-8'); ?>">
                            </td>
                            <td>
                                <span class="role-text"><?php echo htmlspecialchars($row['role'], ENT_QUOTES, 'UTF-8'); ?></span>
                                <select class="form-control role-input d-none">
                                    <option value="admin" <?php echo $row['role'] === 'admin' ? 'selected' : ''; ?>>admin</option>
                                    <option value="superadmin" <?php echo $row['role'] === 'superadmin' ? 'selected' : ''; ?>>superadmin</option>
                                </select>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-btn">Edit</button>
                                <button class="btn btn-success btn-sm save-btn d-none">Save</button>
                                <button class="btn btn-secondary btn-sm cancel-btn d-none">Cancel</button>
                                <button class="btn btn-danger btn-sm delete-btn ml-2">Delete</button>
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
<?php include 'footer.php'; ?>

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

    $(document).on('click', '.edit-btn', function () {
        const row = $(this).closest('tr');
        row.find('.username-text, .email-text, .role-text').addClass('d-none');
        row.find('.username-input, .email-input, .role-input').removeClass('d-none');
        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn, .cancel-btn').removeClass('d-none');
    });

    $(document).on('click', '.cancel-btn', function () {
        const row = $(this).closest('tr');
        row.find('.username-input, .email-input, .role-input').addClass('d-none');
        row.find('.username-text, .email-text, .role-text').removeClass('d-none');
        row.find('.save-btn, .cancel-btn').addClass('d-none');
        row.find('.edit-btn').removeClass('d-none');
    });

    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const username = row.find('.username-input').val();
        const email = row.find('.email-input').val();
        const role = row.find('.role-input').val();

        $.post('viewadmins.php', {
            action: 'update',
            id: id,
            username: username,
            email: email,
            role: role
        }).done(function (response) {
            if (response === 'success') {
                row.find('.username-text').text(username);
                row.find('.email-text').text(email);
                row.find('.role-text').text(role);
                row.find('.username-input, .email-input, .role-input').addClass('d-none');
                row.find('.username-text, .email-text, .role-text').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Admin updated',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } else if (response === 'username_exists') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Username already exists',
                    text: 'Please choose a different username.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else if (response === 'email_exists') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Email already exists',
                    text: 'Please choose a different email.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating admin',
                    text: 'Please try again.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        }).fail(function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Network error',
                text: 'Please try again.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    });

    $(document).on('click', '.delete-btn', function () {
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
                }).done(function (response) {
                    if (response === 'success') {
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
                    } else if (response === 'self_delete') {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Cannot delete own account',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    } else {
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'error',
                            title: 'Error deleting admin',
                            text: 'Please try again.',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                }).fail(function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Network error',
                        text: 'Please try again.',
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