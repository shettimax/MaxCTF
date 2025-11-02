<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();

// Fetch distinct skillsets and genders from accounts
$skill_options = [];
$skill_query = mysqli_query($conn, "SELECT DISTINCT ctfskillset FROM accounts WHERE ctfskillset != '' ORDER BY ctfskillset ASC");
while ($s = mysqli_fetch_array($skill_query)) {
    $skill_options[] = $s['ctfskillset'];
}

$gender_options = [];
$gender_query = mysqli_query($conn, "SELECT DISTINCT gender FROM accounts WHERE gender != '' ORDER BY gender ASC");
while ($g = mysqli_fetch_array($gender_query)) {
    $gender_options[] = $g['gender'];
}

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $skill = $_POST['skill'];
        $gender = $_POST['gender'];
        mysqli_query($conn, "UPDATE accounts SET ctfname='$name', ctfskillset='$skill', gender='$gender' WHERE ctfid='$id'");
        $admin = $_SESSION['alogin'];
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','Updated user $id')");
        exit;
    }

    if ($_POST['action'] === 'delete') {
        $id = $_POST['id'];
        $user = mysqli_fetch_array(mysqli_query($conn,"SELECT ctfname FROM accounts WHERE ctfid='$id'"));
        $name = $user['ctfname'];
        mysqli_query($conn,"DELETE FROM accounts WHERE ctfid='$id'");
        $admin = $_SESSION['alogin'];
        mysqli_query($conn,"INSERT INTO auditlog (admin, action) VALUES ('$admin','Deleted user $name')");
        exit;
    }
}
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-users" style="margin-right: 5px;"></i>CTF Players</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">User list</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">All Registered Users</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="userTable" width="100%" cellspacing="0">
<thead>
<tr>
    <th>CTFID</th>
    <th>Name</th>
    <th>Badge</th>
    <th>Skillset</th>
    <th>Gender</th>
    <th>Joined</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$get = "SELECT * FROM accounts ORDER BY ctfscore DESC";
$run = mysqli_query($conn,$get);
while($row = mysqli_fetch_array($run)){
    $ctfid = $row['ctfid'];
    $name = htmlentities($row['ctfname']);
    $score = $row['ctfscore'];
    $skill = htmlentities($row['ctfskillset']);
    $gender = htmlentities($row['gender']);
    $joined = htmlentities($row['joined']);

    $badge_query = mysqli_query($conn,"SELECT title FROM badges WHERE required_score <= '$score' ORDER BY required_score DESC LIMIT 1");
    $badge = mysqli_fetch_array($badge_query);
    $badge_title = $badge ? $badge['title'] : 'None';
?>
<tr data-id="<?php echo $ctfid; ?>">
    <td><?php echo $ctfid; ?></td>
    <td>
        <span class="name-text"><?php echo $name; ?></span>
        <input type="text" class="form-control name-input d-none" value="<?php echo $name; ?>">
    </td>
    <td><span class="badge badge-success"><?php echo htmlentities($badge_title); ?></span></td>
    <td>
        <span class="skill-text"><?php echo $skill; ?></span>
        <select class="form-control skill-input d-none">
            <?php foreach ($skill_options as $opt) {
                $selected = ($opt == $skill) ? 'selected' : '';
                echo "<option value='".htmlentities($opt)."' $selected>".htmlentities($opt)."</option>";
            } ?>
        </select>
    </td>
    <td>
        <span class="gender-text"><?php echo $gender; ?></span>
        <select class="form-control gender-input d-none">
            <?php foreach ($gender_options as $opt) {
                $selected = ($opt == $gender) ? 'selected' : '';
                echo "<option value='".htmlentities($opt)."' $selected>".htmlentities($opt)."</option>";
            } ?>
        </select>
    </td>
    <td><?php echo $joined; ?></td>
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
    $('#userTable').DataTable({
        pageLength: 50,
        responsive: true
    });

    $(document).on('click', '.edit-btn', function () {
        const row = $(this).closest('tr');
        row.find('.name-text, .skill-text, .gender-text').addClass('d-none');
        row.find('.name-input, .skill-input, .gender-input').removeClass('d-none');
        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn, .cancel-btn').removeClass('d-none');
    });

    $(document).on('click', '.cancel-btn', function () {
        const row = $(this).closest('tr');
        row.find('.name-input, .skill-input, .gender-input').addClass('d-none');
        row.find('.name-text, .skill-text, .gender-text').removeClass('d-none');
        row.find('.save-btn, .cancel-btn').addClass('d-none');
        row.find('.edit-btn').removeClass('d-none');
    });

    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.find('.name-input').val();
        const skill = row.find('.skill-input').val();
        const gender = row.find('.gender-input').val();

        $.post('userz.php', {
            action: 'update',
            id: id,
            name: name,
            skill: skill,
            gender: gender
        }).done(function () {
            row.find('.name-text').text(name);
            row.find('.skill-text').text(skill);
            row.find('.gender-text').text(gender);
            row.find('.name-input, .skill-input, .gender-input').addClass('d-none');
            row.find('.name-text, .skill-text, .gender-text').removeClass('d-none');
            row.find('.save-btn, .cancel-btn').addClass('d-none');
            row.find('.edit-btn').removeClass('d-none');
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'User updated',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true
            });
        }).fail(function () {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: 'Something went wrong',
                text: 'Could not update user.',
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
            title: 'Delete this user?',
            icon: 'warning',
            showCancelButton: true,
                        confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('userz.php', { action: 'delete', id: id })
                .done(function () {
                    row.remove();
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: 'User deleted',
                        showConfirmButton: false,
                        timer: 2000,
                        timerProgressBar: true
                    });
                })
                .fail(function () {
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'error',
                        title: 'Something went wrong',
                        text: 'Could not delete user.',
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
