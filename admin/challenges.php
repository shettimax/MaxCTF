<?php
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
    exit();
}

// Add challenge
if (isset($_POST['add'])) {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $target_id = $_POST['target_id'];

    $sql = "INSERT INTO challenges (title, description, points, category, status, start_time, end_time, target_id) 
            VALUES ('$title','$desc','$points','$category','$status','$start','$end','$target_id')";
    $_SESSION['challenge_alert'] = mysqli_query($conn, $sql)
        ? ['type' => 'success', 'msg' => 'Challenge added successfully.']
        : ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
    header("Location: challenges.php");
    exit();
}

// Update challenge
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $target_id = $_POST['target_id'];

    $sql = "UPDATE challenges SET title='$title', description='$desc', points='$points', category='$category', status='$status', start_time='$start', end_time='$end', target_id='$target_id' WHERE id='$id'";
    $_SESSION['challenge_alert'] = mysqli_query($conn, $sql)
        ? ['type' => 'success', 'msg' => 'Challenge updated successfully.']
        : ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
    header("Location: challenges.php");
    exit();
}

// Delete challenge
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM challenges WHERE id='$id'");
    $_SESSION['challenge_alert'] = ['type' => 'success', 'msg' => 'Challenge deleted.'];
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
    <button class="btn btn-sm btn-success" onclick="toggleChallengeForm()">+</button>
</div>
<div class="card-body" id="addChallengeForm" style="display:none;">
<form method="post">
    <input type="text" name="title" class="form-control mb-2" placeholder="Title" required>
    <textarea name="description" class="form-control mb-2" placeholder="Description" required></textarea>
    <input type="number" name="points" class="form-control mb-2" placeholder="Points" required>
    <input type="text" name="category" class="form-control mb-2" placeholder="Category">
    <select name="status" class="form-control mb-2">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <input type="datetime-local" name="start_time" class="form-control mb-2">
    <input type="datetime-local" name="end_time" class="form-control mb-2">
    <select name="target_id" class="form-control mb-2">
        <option value="">-- Select Target --</option>
        <?php
        $targets = mysqli_query($conn, "SELECT id, name FROM targets");
        while ($t = mysqli_fetch_array($targets)) {
            echo "<option value='{$t['id']}'>{$t['name']}</option>";
        }
        ?>
    </select>
    <button type="submit" name="add" class="btn btn-primary">Add Challenge</button>
</form>
</div>
</div>

<!-- Challenges Table -->
<div class="card mb-4">
<div class="card-header">Existing Challenges</div>
<div class="card-body">
<table class="table table-bordered">
<thead><tr><th>ID</th><th>Title</th><th>Points</th><th>Category</th><th>Status</th><th>Target</th><th>Action</th></tr></thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT c.*, t.name AS target_name FROM challenges c LEFT JOIN targets t ON c.target_id = t.id ORDER BY c.points DESC");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlentities($row['title']) ?></td>
    <td><?= $row['points'] ?></td>
    <td><?= htmlentities($row['category']) ?></td>
    <td><?= htmlentities($row['status']) ?></td>
    <td><?= htmlentities($row['target_name']) ?></td>
    <td>
        <button class="btn btn-warning btn-sm" onclick="editChallenge(<?= $row['id'] ?>,'<?= addslashes($row['title']) ?>','<?= addslashes($row['description']) ?>','<?= $row['points'] ?>','<?= addslashes($row['category']) ?>','<?= $row['status'] ?>','<?= $row['start_time'] ?>','<?= $row['end_time'] ?>','<?= $row['target_id'] ?>')">Edit</button>
        <a href="challenges.php?del=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
<div class="modal-header"><h5 class="modal-title">Edit Challenge</h5></div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <input type="text" name="title" id="editTitle" class="form-control mb-2" required>
    <textarea name="description" id="editDesc" class="form-control mb-2" required></textarea>
    <input type="number" name="points" id="editPoints" class="form-control mb-2" required>
    <input type="text" name="category" id="editCategory" class="form-control mb-2">
    <select name="status" id="editStatus" class="form-control mb-2">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <input type="datetime-local" name="start_time" id="editStart" class="form-control mb-2">
    <input type="datetime-local" name="end_time" id="editEnd" class="form-control mb-2">
    <select name="target_id" id="editTarget" class="form-control mb-2">
        <?php
        $targets = mysqli_query($conn, "SELECT id, name FROM targets");
        while ($t = mysqli_fetch_array($targets)) {
            echo "<option value='{$t['id']}'>{$t['name']}</option>";
        }
        ?>
    </select>
</div>
<div class="modal-footer">
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>
</div>

<script>
function toggleChallengeForm() {
    const form = document.getElementById('addChallengeForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function editChallenge(id, title, desc, points, category, status, start, end, target_id) {
    document.getElementById('editId').value = id;
        document.getElementById('editTitle').value = title;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editPoints').value = points;
    document.getElementById('editCategory').value = category;
    document.getElementById('editStatus').value = status;
    document.getElementById('editStart').value = start.replace(' ', 'T');
    document.getElementById('editEnd').value = end.replace(' ', 'T');

    const targetSelect = document.getElementById('editTarget');
    for (let i = 0; i < targetSelect.options.length; i++) {
        if (targetSelect.options[i].value === target_id) {
            targetSelect.selectedIndex = i;
            break;
        }
    }

    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
<?php include 'footer.php'; ?>
