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

// Add target
if (isset($_POST['add'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $path = mysqli_real_escape_string($conn, $_POST['path']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $category = mysqli_real_escape_string($conn, $_POST['category'] ?: $path);

    // Validate inputs
    if (!empty($name) && !empty($path)) {
        $sql = "INSERT INTO targets (name, path, status, difficulty, category) VALUES ('$name','$path','$status','$difficulty','$category')";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['target_alert'] = ['type' => 'success', 'msg' => 'Target added successfully.'];
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Added target: $name";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
        } else {
            $_SESSION['target_alert'] = ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
    } else {
        $_SESSION['target_alert'] = ['type' => 'error', 'msg' => 'Please fill all required fields.'];
    }
    header("Location: targets.php");
    exit();
}

// Update target
if (isset($_POST['update'])) {
    $id = intval($_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $path = mysqli_real_escape_string($conn, $_POST['path']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $difficulty = mysqli_real_escape_string($conn, $_POST['difficulty']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);

    // Validate inputs
    if ($id > 0 && !empty($name) && !empty($path)) {
        $sql = "UPDATE targets SET name='$name', path='$path', status='$status', difficulty='$difficulty', category='$category' WHERE id='$id'";
        
        if (mysqli_query($conn, $sql)) {
            $_SESSION['target_alert'] = ['type' => 'success', 'msg' => 'Target updated successfully.'];
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Updated target: $name";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
        } else {
            $_SESSION['target_alert'] = ['type' => 'error', 'msg' => 'Error: ' . mysqli_error($conn)];
        }
    } else {
        $_SESSION['target_alert'] = ['type' => 'error', 'msg' => 'Invalid input data.'];
    }
    header("Location: targets.php");
    exit();
}

// Delete target
if (isset($_GET['del'])) {
    $id = intval($_GET['del']);
    
    if ($id > 0) {
        // Get target name for audit log
        $target = mysqli_fetch_array(mysqli_query($conn, "SELECT name FROM targets WHERE id='$id'"));
        $name = mysqli_real_escape_string($conn, $target['name']);
        
        mysqli_query($conn, "DELETE FROM targets WHERE id='$id'");
        $_SESSION['target_alert'] = ['type' => 'success', 'msg' => 'Target deleted.'];
        
        $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
        $action = "Deleted target: $name";
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
    }
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
    <button type="button" class="btn btn-sm btn-success" id="toggleTargetForm">+</button>
</div>
<div class="card-body" id="addTargetForm" style="display:none;">
<form method="post">
    <div class="form-group">
        <label for="targetName">Name *</label>
        <input type="text" name="name" id="targetName" class="form-control mb-2" placeholder="Name" required maxlength="100">
    </div>
    <div class="form-group">
        <label for="targetPath">Folder *</label>
        <select name="path" id="targetPath" class="form-control mb-2" required>
            <option value="">-- Select Folder --</option>
            <?php
            $used = mysqli_query($conn, "SELECT path FROM targets");
            $usedPaths = array_column(mysqli_fetch_all($used, MYSQLI_ASSOC), 'path');
            foreach (scandir('../targets') as $folder) {
                if ($folder === '.' || $folder === '..') continue;
                if (is_dir("../targets/$folder") && !in_array($folder, $usedPaths)) {
                    $safe_folder = htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');
                    echo "<option value='$safe_folder'>$safe_folder</option>";
                }
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="targetStatus">Status</label>
        <select name="status" id="targetStatus" class="form-control mb-2">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="targetDifficulty">Difficulty</label>
        <select name="difficulty" id="targetDifficulty" class="form-control mb-2">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </div>
    <div class="form-group">
        <label for="targetCategory">Category</label>
        <input type="text" name="category" id="targetCategory" class="form-control mb-2" placeholder="Category" maxlength="100">
    </div>
    <button type="submit" name="add" class="btn btn-primary">Add Target</button>
</form>
</div>
</div>

<!-- Targets Table -->
<div class="card mb-4">
<div class="card-header">Existing Targets</div>
<div class="card-body">
<table class="table table-bordered" id="targetsTable">
<thead>
    <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Path</th>
        <th>Status</th>
        <th>Difficulty</th>
        <th>Category</th>
        <th>Action</th>
    </tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT * FROM targets ORDER BY difficulty ASC");
while($row = mysqli_fetch_array($get)){
    $id = intval($row['id']);
    $name = htmlspecialchars($row['name'], ENT_QUOTES, 'UTF-8');
    $path = htmlspecialchars($row['path'], ENT_QUOTES, 'UTF-8');
    $status = htmlspecialchars($row['status'], ENT_QUOTES, 'UTF-8');
    $difficulty = htmlspecialchars($row['difficulty'], ENT_QUOTES, 'UTF-8');
    $category = htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8');
?>
<tr data-id="<?= $id ?>" 
    data-name="<?= $name ?>" 
    data-path="<?= $path ?>" 
    data-status="<?= $status ?>" 
    data-difficulty="<?= $difficulty ?>" 
    data-category="<?= $category ?>">
    <td><?= $id ?></td>
    <td><?= $name ?></td>
    <td><?= $path ?></td>
    <td><?= $status ?></td>
    <td><?= $difficulty ?></td>
    <td><?= $category ?></td>
    <td>
        <button class="btn btn-warning btn-sm edit-target-btn">Edit</button>
        <button class="btn btn-danger btn-sm delete-target-btn">Delete</button>
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
    <h5 class="modal-title">Edit Target</h5>
    <button type="button" class="close text-green" data-dismiss="modal">&times;</button>
</div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <div class="form-group">
        <label for="editName">Name *</label>
        <input type="text" name="name" id="editName" class="form-control mb-2" required maxlength="100">
    </div>
    <div class="form-group">
        <label for="editPath">Path *</label>
        <select name="path" id="editPath" class="form-control mb-2" required>
            <?php
            foreach (scandir('../targets') as $folder) {
                if ($folder === '.' || $folder === '..') continue;
                $safe_folder = htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');
                echo "<option value='$safe_folder'>$safe_folder</option>";
            }
            ?>
        </select>
    </div>
    <div class="form-group">
        <label for="editStatus">Status</label>
        <select name="status" id="editStatus" class="form-control mb-2">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
    </div>
    <div class="form-group">
        <label for="editDifficulty">Difficulty</label>
        <select name="difficulty" id="editDifficulty" class="form-control mb-2">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
    </div>
    <div class="form-group">
        <label for="editCategory">Category</label>
        <input type="text" name="category" id="editCategory" class="form-control mb-2" maxlength="100">
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
    // Toggle add target form
    $('#toggleTargetForm').click(function() {
        $('#addTargetForm').slideToggle();
    });

    // Edit target button click
    $(document).on('click', '.edit-target-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.data('name');
        const path = row.data('path');
        const status = row.data('status');
        const difficulty = row.data('difficulty');
        const category = row.data('category');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editStatus').val(status);
        $('#editDifficulty').val(difficulty);
        $('#editCategory').val(category);
        
        const pathSelect = $('#editPath');
        pathSelect.val(path);

        // Show modal
        $('#editModal').modal('show');
    });

    // Delete target confirmation
    $(document).on('click', '.delete-target-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.data('name');

        Swal.fire({
            title: 'Delete Target?',
            text: `Are you sure you want to delete "${name}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'targets.php?del=' + id;
            }
        });
    });
});
</script>

<?php include 'footer.php'; ?>