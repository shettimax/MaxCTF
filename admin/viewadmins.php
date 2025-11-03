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
                            <td class="username"><?php echo htmlentities($row['username']); ?></td>
                            <td class="email"><?php echo htmlentities($row['email']); ?></td>
                            <td class="role"><?php echo htmlentities($row['role']); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm edit-toggle">Edit</button>
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
<?php include 'footer.php'; ?>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-green">
      <div class="modal-header">
        <h5 class="modal-title">Confirm Delete</h5>
        <button type="button" class="close text-green" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this admin?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger confirm-delete">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- DataTables + SweetAlert2 -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {
    $('#adminTable').DataTable({
        pageLength: 25,
        responsive: true
    });

    let deleteId = null;

    $(document).on('click', '.edit-toggle', function () {
        const row = $(this).closest('tr');
        const username = row.find('.username').text();
        const email = row.find('.email').text();
        const role = row.find('.role').text();

        row.find('.username').html(`<input type="text" class="form-control username-edit" value="${username}" data-original="${username}">`);
        row.find('.email').html(`<input type="text" class="form-control email-edit" value="${email}" data-original="${email}">`);
        row.find('.role').html(`
            <select class="form-control role-edit" data-original="${role}">
                <option value="admin" ${role === 'admin' ? 'selected' : ''}>admin</option>
                <option value="superadmin" ${role === 'superadmin' ? 'selected' : ''}>superadmin</option>
            </select>
        `);
        $(this).replaceWith(`
            <button class="btn btn-success btn-sm save-edit">Save</button>
            <button class="btn btn-secondary btn-sm cancel-edit ml-2">Cancel</button>
        `);
    });

    $(document).on('click', '.save-edit', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const username = row.find('.username-edit').val();
        const email = row.find('.email-edit').val();
        const role = row.find('.role-edit').val();

        $.post('viewadmins.php', {
            action: 'edit',
            id, username, email, role
        }).done(() => location.reload());
    });

    $(document).on('click', '.cancel-edit', function () {
        const row = $(this).closest('tr');
        const originalUsername = row.find('.username-edit').data('original');
        const originalEmail = row.find('.email-edit').data('original');
        const originalRole = row.find('.role-edit').data('original');

        row.find('.username').text(originalUsername);
        row.find('.email').text(originalEmail);
        row.find('.role').text(originalRole);

        row.find('.save-edit').remove();
        $(this).remove();
        row.find('td:last-child').prepend(`<button class="btn btn-warning btn-sm edit-toggle">Edit</button>`);
    });

    $(document).on('click', '.delete', function () {
        deleteId = $(this).closest('tr').data('id');
        $('#deleteModal').modal('show');
    });

    $(document).on('click', '.confirm-delete', function () {
        $.post('viewadmins.php', {
            action: 'delete',
            id: deleteId
        }).done(() => location.reload());
    });
});
</script>
