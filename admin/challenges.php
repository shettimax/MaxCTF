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

// Update challenge
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $desc = mysqli_real_escape_string($conn, $_POST['description']);
    $points = intval($_POST['points']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $start = mysqli_real_escape_string($conn, $_POST['start_time']);
    $end = mysqli_real_escape_string($conn, $_POST['end_time']);
    $target_id = intval($_POST['target_id']);

    // Validate inputs
    if ($id > 0 && !empty($title) && !empty($desc) && $points >= 0) {
        $sql = "UPDATE challenges SET title='$title', description='$desc', points='$points', category='$category', status='$status', start_time='$start', end_time='$end', target_id='$target_id' WHERE id='$id'";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['challenge_alert'] = ['type' => 'success', 'msg' => 'Challenge updated successfully.'];
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Updated challenge: $title";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
        } else {
            $_SESSION['challenge_alert'] = ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
    } else {
        $_SESSION['challenge_alert'] = ['type' => 'error', 'msg' => 'Invalid input data.'];
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
    $start_time = htmlspecialchars($row['start_time'], ENT_QUOTES, 'UTF-8');
    $end_time = htmlspecialchars($row['end_time'], ENT_QUOTES, 'UTF-8');
    $target_id = intval($row['target_id']);
?>
<tr data-id="<?= $id ?>" 
    data-title="<?= $title ?>" 
    data-description="<?= $description ?>" 
    data-points="<?= $points ?>" 
    data-category="<?= $category ?>" 
    data-status="<?= $status ?>" 
    data-start_time="<?= $start_time ?>" 
    data-end_time="<?= $end_time ?>" 
    data-target_id="<?= $target_id ?>">
    <td><?= $id ?></td>
    <td><?= $title ?></td>
    <td><?= $points ?></td>
    <td><?= $category ?></td>
    <td><?= $status ?></td>
    <td><?= $target_name ?></td>
    <td>
        <button class="btn btn-warning btn-sm edit-challenge-btn">Edit</button>
        <button class="btn btn-danger btn-sm delete-challenge-btn">Delete</button>
    </td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</main>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content">
<form method="post">
<div class="modal-header">
    <h5 class="modal-title">Edit Challenge</h5>
    <button type="button" class="close text-green" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <div class="form-group">
        <label for="editTitle">Title *</label>
        <input type="text" name="title" id="editTitle" class="form-control mb-2" required maxlength="255">
    </div>
    <div class="form-group">
        <label for="editDesc">Description *</label>
        <textarea name="description" id="editDesc" class="form-control mb-2" required maxlength="1000"></textarea>
    </div>
    <div class="form-group">
        <label for="editPoints">Points *</label>
        <input type="number" name="points" id="editPoints" class="form-control mb-2" required min="0" max="10000">
    </div>
    <div class="form-group">
        <label for="editCategory">Category</label>
        <input type="text" name="category" id="editCategory" class="form-control mb-2" maxlength="100">
    </div>
    <div class="form-group">
        <label for="editStatus">Status</label>
        <select name="status" id="editStatus" class="form-control mb-2">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="editStart">Start Time</label>
        <input type="datetime-local" name="start_time" id="editStart" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="editEnd">End Time</label>
        <input type="datetime-local" name="end_time" id="editEnd" class="form-control mb-2">
    </div>
    <div class="form-group">
        <label for="editTarget">Target</label>
        <select name="target_id" id="editTarget" class="form-control mb-2">
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
</div>
<div class="modal-footer">
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // Toggle add challenge form
    $('#toggleChallengeForm').click(function() {
        $('#addChallengeForm').slideToggle();
    });

    // Edit challenge button click
    $(document).on('click', '.edit-challenge-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.data('title');
        const description = row.data('description');
        const points = row.data('points');
        const category = row.data('category');
        const status = row.data('status');
        const start_time = row.data('start_time');
        const end_time = row.data('end_time');
        const target_id = row.data('target_id');

        $('#editId').val(id);
        $('#editTitle').val(title);
        $('#editDesc').val(description);
        $('#editPoints').val(points);
        $('#editCategory').val(category);
        $('#editStatus').val(status);
        
        // Format datetime for input fields
        $('#editStart').val(start_time ? start_time.replace(' ', 'T').substr(0, 16) : '');
        $('#editEnd').val(end_time ? end_time.replace(' ', 'T').substr(0, 16) : '');

        // Set target selection
        $('#editTarget').val(target_id);

        // Show modal
        $('#editModal').modal('show');
    });

    // Delete challenge confirmation
    $(document).on('click', '.delete-challenge-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const title = row.data('title');

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