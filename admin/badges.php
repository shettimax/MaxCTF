<?php
ob_start();
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0 || $_SESSION['role'] != 'admin'){
    header('location:index.php');
}
ob_end_flush();

// Handle AJAX actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $vibe = mysqli_real_escape_string($conn, $_POST['vibe']);
        $score = intval($_POST['score']);
        
        // Validate inputs
        if ($id > 0 && !empty($title) && $score >= 0) {
            mysqli_query($conn, "UPDATE badges SET title='$title', vibe='$vibe', required_score='$score' WHERE id='$id'");
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Updated badge $title";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
            echo "success";
        }
        exit;
    }

    if ($_POST['action'] === 'delete') {
        $id = intval($_POST['id']);
        
        if ($id > 0) {
            $badge = mysqli_fetch_array(mysqli_query($conn,"SELECT title FROM badges WHERE id='$id'"));
            $title = mysqli_real_escape_string($conn, $badge['title']);
            mysqli_query($conn,"DELETE FROM badges WHERE id='$id'");
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            mysqli_query($conn,"INSERT INTO auditlog (admin, action) VALUES ('$admin','Deleted badge $title')");
            echo "success";
        }
        exit;
    }

    if ($_POST['action'] === 'add') {
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $vibe = mysqli_real_escape_string($conn, $_POST['vibe']);
        $score = intval($_POST['required_score']);
        
        // Validate inputs
        if (!empty($title) && !empty($vibe) && $score >= 0) {
            mysqli_query($conn,"INSERT INTO badges (title, vibe, required_score) VALUES ('$title','$vibe','$score')");
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Added badge $title";
            mysqli_query($conn,"INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
            echo "success";
        }
        exit;
    }
}
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-award"></i> Badge Manager</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage badges</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Add New Badge</div>
<div class="card-body">
<form id="addBadgeForm">
    <div class="form-group">
        <label for="badgeTitle">Title</label>
        <input type="text" name="title" id="badgeTitle" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="badgeVibe">Vibe (icon or description)</label>
        <input type="text" name="vibe" id="badgeVibe" class="form-control" required>
    </div>
    <div class="form-group">
        <label for="badgeScore">Required Score</label>
        <input type="number" name="required_score" id="badgeScore" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary mt-3">Add Badge</button>
</form>
</div>
</div>

<div class="card mb-4">
<div class="card-header text-green">Existing Badges</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="badgeTable">
<thead>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Vibe</th>
    <th>Required Score</th>
    <th>Preview</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT * FROM badges ORDER BY required_score ASC");
while($row = mysqli_fetch_array($get)){
    $id = intval($row['id']);
    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
    $vibe = htmlspecialchars($row['vibe'], ENT_QUOTES, 'UTF-8');
    $score = intval($row['required_score']);
    $badgePath = "../badges/$id.png";
?>
<tr data-id="<?php echo $id; ?>">
    <td><?php echo $id; ?></td>
    <td>
        <span class="title-text"><?php echo $title; ?></span>
        <input type="text" class="form-control title-input d-none" value="<?php echo $title; ?>">
    </td>
    <td>
        <span class="vibe-text"><?php echo $vibe; ?></span>
        <input type="text" class="form-control vibe-input d-none" value="<?php echo $vibe; ?>">
    </td>
    <td>
        <span class="score-text"><?php echo $score; ?></span>
        <input type="number" class="form-control score-input d-none" value="<?php echo $score; ?>">
    </td>
    <td>
        <?php 
        if (file_exists($badgePath)) {
            $imageData = base64_encode(file_get_contents($badgePath));
            echo "<img src='data:image/png;base64,$imageData' alt='Badge $title' title='$vibe' width='80'>";
        } else {
            echo "<img src='assets/locked.png' alt='Locked Badge' title='Locked badge' width='80'>";
        }
        ?>
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function () {
    // Add badge
    $('#addBadgeForm').submit(function (e) {
        e.preventDefault();
        const formData = $(this).serialize() + '&action=add';
        $.post('badges.php', formData, function (response) {
            if (response === 'success') {
                Swal.fire({ icon: 'success', title: 'Badge added', showConfirmButton: false, timer: 1500 });
                setTimeout(() => location.reload(), 1600);
            } else {
                Swal.fire({ icon: 'error', title: 'Error adding badge', timer: 1500 });
            }
        }).fail(function() {
            Swal.fire({ icon: 'error', title: 'Error adding badge', timer: 1500 });
        });
    });

    // Edit mode toggle
    $(document).on('click', '.edit-btn', function () {
        const row = $(this).closest('tr');
        row.find('.title-text, .vibe-text, .score-text').addClass('d-none');
        row.find('.title-input, .vibe-input, .score-input').removeClass('d-none');
        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn, .cancel-btn').removeClass('d-none');
    });

    // Cancel edit
    $(document).on('click', '.cancel-btn', function () {
        const row = $(this).closest('tr');
        row.find('.title-input, .vibe-input, .score-input').addClass('d-none');
        row.find('.title-text, .vibe-text, .score-text').removeClass('d-none');
        row.find('.save-btn, .cancel-btn').addClass('d-none');
        row.find('.edit-btn').removeClass('d-none');
    });

    // Save badge edits
    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.find('.title-input').val();
        const vibe = row.find('.vibe-input').val();
        const score = row.find('.score-input').val();

        $.post('badges.php', {
            action: 'update',
            id: id,
            title: title,
            vibe: vibe,
            score: score
        }, function (response) {
            if (response === 'success') {
                row.find('.title-text').text(title);
                row.find('.vibe-text').text(vibe);
                row.find('.score-text').text(score);
                row.find('.title-input, .vibe-input, .score-input').addClass('d-none');
                row.find('.title-text, .vibe-text, .score-text').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
                Swal.fire({ icon: 'success', title: 'Badge updated', showConfirmButton: false, timer: 1500 });
            } else {
                Swal.fire({ icon: 'error', title: 'Error updating badge', timer: 1500 });
            }
        }).fail(function() {
            Swal.fire({ icon: 'error', title: 'Error updating badge', timer: 1500 });
        });
    });

    // Delete badge
    $(document).on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');

        Swal.fire({
            title: 'Delete this badge?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.post('badges.php', { 
                    action: 'delete', 
                    id: id
                }, function (response) {
                    if (response === 'success') {
                        row.remove();
                        Swal.fire({
                            icon: 'success',
                            title: 'Badge deleted',
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        Swal.fire({ icon: 'error', title: 'Error deleting badge', timer: 1500 });
                    }
                }).fail(function() {
                    Swal.fire({ icon: 'error', title: 'Error deleting badge', timer: 1500 });
                });
            }
        });
    });
});
</script>