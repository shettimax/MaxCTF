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

// Handle AJAX update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
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
            $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);
            $action = "Updated target: $name";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "invalid_data";
    }
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
<div class="table-responsive">
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
<tr data-id="<?= $id ?>">
    <td><?= $id ?></td>
    <td>
        <span class="name-text"><?= $name ?></span>
        <input type="text" class="form-control name-input d-none" value="<?= $name ?>" maxlength="100">
    </td>
    <td>
        <span class="path-text"><?= $path ?></span>
        <select class="form-control path-input d-none">
            <?php
            foreach (scandir('../targets') as $folder) {
                if ($folder === '.' || $folder === '..') continue;
                $safe_folder = htmlspecialchars($folder, ENT_QUOTES, 'UTF-8');
                $selected = $path === $folder ? 'selected' : '';
                echo "<option value='$safe_folder' $selected>$safe_folder</option>";
            }
            ?>
        </select>
    </td>
    <td>
        <span class="status-text"><?= $status ?></span>
        <select class="form-control status-input d-none">
            <option value="active" <?= $status === 'active' ? 'selected' : '' ?>>active</option>
            <option value="inactive" <?= $status === 'inactive' ? 'selected' : '' ?>>inactive</option>
        </select>
    </td>
    <td>
        <span class="difficulty-text"><?= $difficulty ?></span>
        <select class="form-control difficulty-input d-none">
            <option value="easy" <?= $difficulty === 'easy' ? 'selected' : '' ?>>easy</option>
            <option value="medium" <?= $difficulty === 'medium' ? 'selected' : '' ?>>medium</option>
            <option value="hard" <?= $difficulty === 'hard' ? 'selected' : '' ?>>hard</option>
        </select>
    </td>
    <td>
        <span class="category-text"><?= $category ?></span>
        <input type="text" class="form-control category-input d-none" value="<?= $category ?>" maxlength="100">
    </td>
    <td>
        <button class="btn btn-warning btn-sm edit-target-btn">Edit</button>
        <button class="btn btn-success btn-sm save-target-btn d-none">Save</button>
        <button class="btn btn-secondary btn-sm cancel-target-btn d-none">Cancel</button>
        <button class="btn btn-danger btn-sm delete-target-btn ml-2">Delete</button>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- DataTables CSS & JS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    $('#targetsTable').DataTable({
        pageLength: 25,
        responsive: true
    });

    // Toggle add target form
    $('#toggleTargetForm').click(function() {
        $('#addTargetForm').slideToggle();
    });

    // Edit target button click
    $(document).on('click', '.edit-target-btn', function() {
        const row = $(this).closest('tr');
        row.find('.name-text, .path-text, .status-text, .difficulty-text, .category-text').addClass('d-none');
        row.find('.name-input, .path-input, .status-input, .difficulty-input, .category-input').removeClass('d-none');
        row.find('.edit-target-btn').addClass('d-none');
        row.find('.save-target-btn, .cancel-target-btn').removeClass('d-none');
    });

    // Cancel button click
    $(document).on('click', '.cancel-target-btn', function() {
        const row = $(this).closest('tr');
        row.find('.name-input, .path-input, .status-input, .difficulty-input, .category-input').addClass('d-none');
        row.find('.name-text, .path-text, .status-text, .difficulty-text, .category-text').removeClass('d-none');
        row.find('.save-target-btn, .cancel-target-btn').addClass('d-none');
        row.find('.edit-target-btn').removeClass('d-none');
    });

    // Save button click
    $(document).on('click', '.save-target-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.find('.name-input').val();
        const path = row.find('.path-input').val();
        const status = row.find('.status-input').val();
        const difficulty = row.find('.difficulty-input').val();
        const category = row.find('.category-input').val();

        $.post('targets.php', {
            action: 'update',
            id: id,
            name: name,
            path: path,
            status: status,
            difficulty: difficulty,
            category: category
        }).done(function(response) {
            if (response === 'success') {
                // Update displayed values
                row.find('.name-text').text(name);
                row.find('.path-text').text(path);
                row.find('.status-text').text(status);
                row.find('.difficulty-text').text(difficulty);
                row.find('.category-text').text(category);
                
                // Hide inputs, show text
                row.find('.name-input, .path-input, .status-input, .difficulty-input, .category-input').addClass('d-none');
                row.find('.name-text, .path-text, .status-text, .difficulty-text, .category-text').removeClass('d-none');
                row.find('.save-target-btn, .cancel-target-btn').addClass('d-none');
                row.find('.edit-target-btn').removeClass('d-none');
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Target updated successfully',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true
                });
            } else {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'error',
                    title: 'Error updating target',
                    text: 'Please try again.',
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true
                });
            }
        }).fail(function() {
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

    // Delete target confirmation
    $(document).on('click', '.delete-target-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const name = row.find('.name-text').text();

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