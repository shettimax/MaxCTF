<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();

// Create folder
if(isset($_POST['create_folder'])){
    $folder = $_POST['new_folder'];
    $targetDir = '../targets/' . $folder;
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }
    header("Location: targets.php");
}

// Add target
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $path = $_POST['path'];
    $status = $_POST['status'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'] ?: $path;
    mysqli_query($conn,"INSERT INTO targets (name, path, status, difficulty, category) VALUES ('$name','$path','$status','$difficulty','$category')");
    header("Location: targets.php");
}

// Update target
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $path = $_POST['path'];
    $status = $_POST['status'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'];

    $check = mysqli_query($conn, "SELECT id FROM targets WHERE path='$path' AND id!='$id'");
    if(mysqli_num_rows($check) > 0){
        echo "<script>alert('This path is already assigned to another target.'); window.location='targets.php';</script>";
        exit;
    }

    mysqli_query($conn,"UPDATE targets SET name='$name', path='$path', status='$status', difficulty='$difficulty', category='$category' WHERE id='$id'");
    header("Location: targets.php");
}

// Delete target
if(isset($_GET['del'])){
    $id = $_GET['del'];
    mysqli_query($conn,"DELETE FROM targets WHERE id='$id'");
    header("Location: targets.php");
}
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-crosshairs" style="margin-right: 5px;"></i> Target Manager</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage vulnerable apps</li>
</ol>

<!-- Add Target Toggle -->
<div class="card mb-4">
<div class="card-header text-green d-flex justify-content-between align-items-center">
    <span><i class="fas fa-plus-circle"></i> Add New Target</span>
    <button class="btn btn-sm btn-success" onclick="toggleTargetForm()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body" id="addTargetForm" style="display: none;">
<form method="post">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>

        <label>Path</label>
        <select name="path" class="form-control" required onchange="autoFillCategory(this)">
            <option value="">-- Select Folder from /targets --</option>
            <?php
            $usedPaths = [];
            $used = mysqli_query($conn, "SELECT path FROM targets");
            while($row = mysqli_fetch_array($used)){
                $usedPaths[] = $row['path'];
            }

            $targetDir = '../targets';
            if (is_dir($targetDir)) {
                $folders = scandir($targetDir);
                foreach ($folders as $folder) {
                    if ($folder === '.' || $folder === '..') continue;
                    if (is_dir("$targetDir/$folder") && !in_array($folder, $usedPaths)) {
                        echo "<option value='$folder'>$folder</option>";
                    }
                }
            }
            ?>
        </select>

        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>

        <label>Difficulty</label>
        <select name="difficulty" class="form-control">
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>

        <label>Category</label>
        <input type="text" name="category" id="categoryInput" class="form-control">

        <button type="submit" name="add" class="btn btn-primary mt-3">Add Target</button>
    </div>
</form>

<!-- Create Folder -->
<form method="post" class="mt-4">
    <div class="form-group">
        <label>Create New Folder in /targets</label>
        <input type="text" name="new_folder" class="form-control" required>
        <button type="submit" name="create_folder" class="btn btn-secondary mt-2">Create Folder</button>
    </div>
</form>
</div>
</div>

<!-- Existing Targets -->
<div class="card mb-4">
<div class="card-header text-green">Existing Targets</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="dataTable" width="100%" cellspacing="0">
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
?>
<tr>
    <td><?php echo htmlentities($row['id']); ?></td>
    <td><?php echo htmlentities($row['name']); ?></td>
    <td><a href="../../<?php echo htmlentities($row['path']); ?>" target="_blank"><?php echo htmlentities($row['path']); ?></a></td>
    <td><?php echo htmlentities($row['status']); ?></td>
    <td><?php echo htmlentities($row['difficulty']); ?></td>
    <td><?php echo htmlentities($row['category']); ?></td>
    <td>
        <button class="btn btn-warning btn-sm" onclick="editTarget('<?php echo $row['id']; ?>','<?php echo addslashes($row['name']); ?>','<?php echo addslashes($row['path']); ?>','<?php echo $row['status']; ?>','<?php echo $row['difficulty']; ?>','<?php echo addslashes($row['category']); ?>')">Edit</button>
        <a href="targets.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content bg-dark text-green">
<form method="post">
<div class="modal-header"><h5 class="modal-title">Edit Target</h5></div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <label>Name</label>
    <input type="text" name="name" id="editName" class="form-control" required>
    <label>Path</label>
    <select name="path" id="editPath" class="form-control" required>
        <option value="">-- Select Folder from /targets --</option>
        <?php
        $targetDir = '../targets';
        if (is_dir($targetDir)) {
            $folders = scandir($targetDir);
            foreach ($folders as $folder) {
                if ($folder === '.' || $folder === '..') continue;
                if (is_dir("$targetDir/$folder")) {
                    echo "<option value='$folder'>$folder</option>";
                }
            }
        }
        ?>
    </select>
    <label>Status</label>
    <select name="status" id="editStatus" class="form-control">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <label>Difficulty</label>
    <select name="difficulty" id="editDifficulty" class="form-control">
        <option value="easy">Easy</option>
        <option value="medium">Medium</option>
        <option value="hard">Hard</option>
    </select>
    <label>Category</label>
    <input type="text" name="category" id="editCategory" class="form-control" required>
</div>
<div class="modal-footer">
    <button type="submit" name="update" class="btn btn-primary">Update</button>
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
</div>
</form>
</div>
</div>
</div>

<!-- JavaScript -->
<script>
function toggleTargetForm() {
    const form = document.getElementById('addTargetForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function autoFillCategory(select) {
    const categoryInput = document.getElementById('categoryInput');
    if (select.value && !categoryInput.value) {
        categoryInput.value = select.value;
    }
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
