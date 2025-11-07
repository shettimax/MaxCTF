<?php
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
    exit();
}

// Handle AJAX actions for inline editing
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if ($_POST['action'] === 'update') {
        $id = intval($_POST['id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $desc = mysqli_real_escape_string($conn, $_POST['description']);
        $points = intval($_POST['points']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);
        
        // Validate inputs
        if ($id > 0 && !empty($title) && !empty($desc) && $points >= 0) {
            $sql = "UPDATE challenges SET title='$title', description='$desc', points='$points', category='$category', status='$status' WHERE id='$id'";
            
            if (mysqli_query($conn, $sql)) {
                $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
                $action = "Updated challenge: $title";
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
}

// Add challenge
if (isset($_POST['add'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $points = intval($_POST['points']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $start = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end = mysqli_real_escape_string($conn, $_POST['end_time']);
    $target_id = intval($_POST['target_id']);

    // Validate inputs
    if (!empty($title) && !empty($desc) && $points >= 0) {
        $sql = "INSERT INTO challenges (title, description, points, category, status, start_time, end_time, target_id) 
                VALUES ('$title','$desc','$points','$category','$status','$start','$end','$target_id')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['challenge_alert'] = ['type' => 'success', 'msg' => 'Challenge added successfully.'];
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Added challenge: $title";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
        } else {
            $_SESSION['challenge_alert'] = ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
    } else {
        $_SESSION['challenge_alert'] = ['type' => 'error', 'msg' => 'Please fill all required fields.'];
    }
    header("Location: challenges.php");
    exit();
}

// Delete challenge
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    
    if ($id > 0) {
        // Get challenge title for audit log
        $challenge = mysqli_fetch_array(mysqli_query($conn, "SELECT title FROM challenges WHERE id='$id'"));
        $title = mysqli_real_escape_string($conn, $challenge['title']);
        
        mysqli_query($conn, "DELETE FROM challenges WHERE id='$id'");
        $_SESSION['challenge_alert'] = ['type' => 'success', 'msg' => 'Challenge deleted.'];
        
        $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
        $action = "Deleted challenge: $title";
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
    }
    header("Location: challenges.php");
    exit();
}
?>

<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4">Challenge Manager</h1>

<?php if (isset($_SESSION['challenge_alert'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  title: '<?= $_SESSION['challenge_alert']['type'] === 'success' ? 'Success' : 'Error' ?>',
  text: '<?= addslashes($_SESSION['challenge_alert']['msg']) ?>',
  icon: '<?= $_SESSION['challenge_alert']['type'] ?>',
  confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['challenge_alert']); endif; ?>

<!-- Add Challenge Form -->
<div class="card mb-4">
<div class="card-header d-flex justify-content-between">
    <span>Add New Challenge</span>
    <button type="button" class="btn btn-sm btn-success" id="toggleChallengeForm">+</button>
</div>
<div class="card-body" id="addChallengeForm" style="display:none;">
<form method="post">
    <div class="form-group">
        <label for="title">Title *</label>
        <input type="text" name="title" id="title" class="form-control mb-2" placeholder="Title" required maxlength="255">
    </div>
    <div class="form-group">
        <label for="description">Description *</label>
        <textarea name="description" id="description" class="form-control mb-2" placeholder="Description" required maxlength="1000"></textarea>
    </div>
    <div class="form-group">
        <label for="points">Points *</label>
        <input type="number" name="points" id="points" class="form-control mb-2" placeholder="Points" required min="0" max="10000">
    </div>
    <div class="form-group">
        <label for="category">Category</label>
        <input type="text" name="category" id="category" class="form-control mb-2" placeholder="Category" maxlength="100">
    </div>
    <div class="form-group">
        <label for="status">Status</label>
        <select name="status" id="status" class="form-control mb-2">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="start_time">Start Time</label>
        <input type="datetime-local" name="start_time" id="start_time" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="end_time">End Time</label>
        <input type="datetime-local" name="end_time" id="end_time" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="target_id">Target</label>
        <select name="target_id" id="target_id" class="form-control mb-2">
            <option value="">-- Select Target --</option>
            <?php
            $targets = mysqli_query($conn, "SELECT id, name FROM targets");
            while ($t = mysqli_fetch_array($targets)) {
                $target_id = intval($t['id']);
                $target_name = htmlspecialchars($t['name'], ENT_QUOTES, 'UTF-8');
                echo "<option value='$target_id'>$target_name</option>";
            }
            ?>
        </select>
    </div>
    <button type="submit" name="add" class="btn btn-primary">Add Challenge</button>
</form>
</div>
</div>

<!-- Challenges Table -->
<div class="card mb-4">
<div class="card-header">Existing Challenges</div>
<div class="card-body">
<table class="table table-bordered" id="challengesTable">
<thead>
    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Points</th>
        <th>Category</th>
        <th>Status</th>
        <th>Target</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT c.*, t.name AS target_name FROM challenges c LEFT JOIN targets t ON c.target_id = t.id ORDER BY c.points DESC");
while($row = mysqli_fetch_array($get)){
    $id = intval($row['id']);
    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
    $points = intval($row['points']);
    $category = htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
    $target_name = htmlspecialchars($row['target_name'] ?: 'None', ENT_QUOTES, 'UTF-8');
    $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
?>
<tr data-id="<?= $id ?>">
    <td><?= $id ?></td>
    <td>
        <span class="title-text"><?= $title ?></span>
        <input type="text" class="form-control title-input d-none" value="<?= $title ?>">
    </td>
    <td>
        <span class="points-text"><?= $points ?></span>
        <input type="number" class="form-control points-input d-none" value="<?= $points ?>">
    </td>
    <td>
        <span class="category-text"><?= $category ?></span>
        <input type="text" class="form-control category-input d-none" value="<?= $category ?>">
    </td>
    <td>
        <span class="status-text"><?= $status ?></span>
        <select class="form-control status-input d-none">
            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </td>
    <td><?= $target_name ?></td>
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
</main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    // Toggle add challenge form
    $('#toggleChallengeForm').click(function() {
        $('#addChallengeForm').slideToggle();
    });

    // Edit button click - Show inputs
    $(document).on('click', '.edit-btn', function () {
        const row = $(this).closest('tr');
        row.find('.title-text, .points-text, .category-text, .status-text').addClass('d-none');
        row.find('.title-input, .points-input, .category-input, .status-input').removeClass('d-none');
        row.find('.edit-btn').addClass('d-none');
        row.find('.save-btn, .cancel-btn').removeClass('d-none');
    });

    // Cancel button click - Hide inputs
    $(document).on('click', '.cancel-btn', function () {
        const row = $(this).closest('tr');
        row.find('.title-input, .points-input, .category-input, .status-input').addClass('d-none');
        row.find('.title-text, .points-text, .category-text, .status-text').removeClass('d-none');
        row.find('.save-btn, .cancel-btn').addClass('d-none');
        row.find('.edit-btn').removeClass('d-none');
    });

    // Save button click - Update data
    $(document).on('click', '.save-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.find('.title-input').val();
        const points = row.find('.points-input').val();
        const category = row.find('.category-input').val();
        const status = row.find('.status-input').val();

        $.post('challenges.php', {
            action: 'update',
            id: id,
            title: title,
            description: title, // Using title as description for simplicity
            points: points,
            category: category,
            status: status
        }).done(function (response) {
            if (response === 'success') {
                // Update displayed values
                row.find('.title-text').text(title);
                row.find('.points-text').text(points);
                row.find('.category-text').text(category);
                row.find('.status-text').text(status);
                
                // Hide inputs, show text
                row.find('.title-input, .points-input, .category-input, .status-input').addClass('d-none');
                row.find('.title-text, .points-text, .category-text, .status-text').removeClass('d-none');
                row.find('.save-btn, .cancel-btn').addClass('d-none');
                row.find('.edit-btn').removeClass('d-none');
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Challenge updated successfully',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating challenge',
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
                text: 'Please check your connection and try again.',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        });
    });

    // Delete button click
    $(document).on('click', '.delete-btn', function () {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.find('.title-text').text();

        Swal.fire({
            title: 'Delete Challenge?',
            text: `Are you sure you want to delete "${title}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'challenges.php?del=' + id;
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>