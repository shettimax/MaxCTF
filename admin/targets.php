<?php
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
    exit();
}

// Add target
if (isset($_POST['add'])) {
    $name = $_POST['name'];
    $path = $_POST['path'];
    $status = $_POST['status'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'] ?: $path;

    $sql = "INSERT INTO targets (name, path, status, difficulty, category) VALUES ('$name','$path','$status','$difficulty','$category')";
    $_SESSION['target_alert'] = mysqli_query($conn, $sql)
        ? ['type' => 'success', 'msg' => 'Target added successfully.']
        : ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
    header("Location: targets.php");
    exit();
}

// Update target
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $path = $_POST['path'];
    $status = $_POST['status'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'];

    $sql = "UPDATE targets SET name='$name', path='$path', status='$status', difficulty='$difficulty', category='$category' WHERE id='$id'";
    $_SESSION['target_alert'] = mysqli_query($conn, $sql)
        ? ['type' => 'success', 'msg' => 'Target updated successfully.']
        : ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
    header("Location: targets.php");
    exit();
}

// Delete target
if (isset($_GET['del'])) {
    $id = $_GET['del'];
    mysqli_query($conn, "DELETE FROM targets WHERE id='$id'");
    $_SESSION['target_alert'] = ['type' => 'success', 'msg' => 'Target deleted.'];
    header("Location: targets.php");
    exit();
}
?>

<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4">Target Manager</h1>

<?php if (isset($_SESSION['target_alert'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
Swal.fire({
  title: '<?= $_SESSION['target_alert']['type'] === 'success' ? 'Success' : 'Error' ?>',
  text: '<?= addslashes($_SESSION['target_alert']['msg']) ?>',
  icon: '<?= $_SESSION['target_alert']['type'] ?>',
  confirmButtonText: 'OK'
});
</script>
<?php unset($_SESSION['target_alert']); endif; ?>

<!-- Add Target Form -->
<div class="card mb-4">
<div class="card-header d-flex justify-content-between">
    <span>Add New Target</span>
    <button class="btn btn-sm btn-success" onclick="toggleTargetForm()">+</button>
</div>
<div class="card-body" id="addTargetForm" style="display:none;">
<form method="post">
    <input type="text" name="name" class="form-control mb-2" placeholder="Name" required>
    <select name="path" class="form-control mb-2" required>
        <option value="">-- Select Folder --</option>
        <?php
        $used = mysqli_query($conn, "SELECT path FROM targets");
        $usedPaths = array_column(mysqli_fetch_all($used, MYSQLI_ASSOC), 'path');
        foreach (scandir('../targets') as $folder) {
            if ($folder === '.' || $folder === '..') continue;
            if (is_dir("../targets/$folder") && !in_array($folder, $usedPaths)) {
                echo "<option value='$folder'>$folder</option>";
            }
        }
        ?>
    </select>
    <select name="status" class="form-control mb-2">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <select name="difficulty" class="form-control mb-2">
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select>
    <input type="text" name="category" class="form-control mb-2" placeholder="Category">
    <button type="submit" name="add" class="btn btn-primary">Add Target</button>
</form>
</div>
</div>

<!-- Targets Table -->
<div class="card mb-4">
<div class="card-header">Existing Targets</div>
<div class="card-body">
<table class="table table-bordered">
<thead><tr><th>ID</th><th>Name</th><th>Path</th><th>Status</th><th>Difficulty</th><th>Category</th><th>Action</th></tr></thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT * FROM targets ORDER BY difficulty ASC");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?= $row['id'] ?></td>
    <td><?= htmlentities($row['name']) ?></td>
    <td><?= htmlentities($row['path']) ?></td>
    <td><?= htmlentities($row['status']) ?></td>
    <td><?= htmlentities($row['difficulty']) ?></td>
    <td><?= htmlentities($row['category']) ?></td>
    <td>
        <button class="btn btn-warning btn-sm" onclick="editTarget(<?= $row['id'] ?>,'<?= addslashes($row['name']) ?>','<?= addslashes($row['path']) ?>','<?= $row['status'] ?>','<?= $row['difficulty'] ?>','<?= addslashes($row['category']) ?>')">Edit</button>
        <a href="targets.php?del=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
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
<div class="modal-header"><h5 class="modal-title">Edit Target</h5></div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <input type="text" name="name" id="editName" class="form-control mb-2" required>
    <select name="path" id="editPath" class="form-control mb-2">
        <?php
        foreach (scandir('../targets') as $folder) {
            if ($folder === '.' || $folder === '..') continue;
            echo "<option value='$folder'>$folder</option>";
        }
        ?>
    </select>
    <select name="status" id="editStatus" class="form-control mb-2">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <select name="difficulty" id="editDifficulty" class="form-control mb-2">
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select>
    <input type="text" name="category" id="editCategory" class="form-control mb-2">
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
function toggleTargetForm() {
    const form = document.getElementById('addTargetForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function editTarget(id, name, path, status, difficulty, category) {
    document.getElementById('editId').value = id;
    document.getElementById('editName').value = name;
    document.getElementById('editStatus').value = status;
    document.getElementById('editDifficulty').value = difficulty;
    document.getElementById('editCategory').value = category;
    const pathSelect = document.getElementById('editPath');
    for (let i = 0; i < pathSelect.options.length; i++) {
        if (pathSelect.options[i].value === path) {
            pathSelect.selectedIndex = i;
            break;
        }
    }
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>
<?php include 'footer.php'; ?>
