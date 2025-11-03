<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();

function generateFlag($title) {
    return "CTF{" . strtoupper(substr(md5($title . time()), 0, 8)) . "}";
}

// Add challenge
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    $flag = isset($_POST['autoflag']) ? generateFlag($title) : $_POST['flag'];
    $status = $_POST['status'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $target_id = $_POST['target_id'];
    mysqli_query($conn,"INSERT INTO challenges (title, description, points, category, flag, status, start_time, end_time, target_id) VALUES ('$title','$desc','$points','$category','$flag','$status','$start','$end','$target_id')");
    header("Location: challenges.php");
}

// Update challenge
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    $flag = $_POST['flag'];
    $status = $_POST['status'];
    $start = $_POST['start_time'];
    $end = $_POST['end_time'];
    $target_id = $_POST['target_id'];
    mysqli_query($conn,"UPDATE challenges SET title='$title', description='$desc', points='$points', category='$category', flag='$flag', status='$status', start_time='$start', end_time='$end', target_id='$target_id' WHERE id='$id'");
    header("Location: challenges.php");
}

// Delete challenge
if(isset($_GET['del'])){
    $id = $_GET['del'];
    mysqli_query($conn,"DELETE FROM challenges WHERE id='$id'");
    header("Location: challenges.php");
}
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-puzzle-piece"></i> Challenge Manager</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage challenges</li>
</ol>

<!-- Add Challenge Toggle -->
<div class="card mb-4">
<div class="card-header text-green d-flex justify-content-between align-items-center">
    <span><i class="fas fa-plus-circle"></i> Add New Challenge</span>
    <button class="btn btn-sm btn-success" onclick="toggleAddForm()">
        <i class="fas fa-plus"></i>
    </button>
</div>
<div class="card-body" id="addChallengeForm" style="display: none;">
<form method="post">
    <div class="form-group">
        <label>Title</label>
        <input type="text" name="title" class="form-control" required>
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
        <label>Points</label>
        <input type="number" name="points" class="form-control" required>
        <label>Category</label>
        <input type="text" name="category" class="form-control" required>
        <label>Flag</label>
        <input type="text" name="flag" class="form-control" id="flagInput">
        <div class="form-check mt-2">
            <input type="checkbox" name="autoflag" class="form-check-input" id="autoflag" onchange="toggleFlagInput()">
            <label class="form-check-label" for="autoflag">Auto-generate flag</label>
        </div>
        <label>Target</label>
        <select name="target_id" class="form-control" required>
            <option value="">-- Select Target --</option>
            <?php
            $targets = mysqli_query($conn,"SELECT id, name FROM targets WHERE status='active'");
            while($t = mysqli_fetch_array($targets)){
                echo "<option value='{$t['id']}'>{$t['name']}</option>";
            }
            ?>
        </select>
        <label>Start Time</label>
        <input type="datetime-local" name="start_time" class="form-control">
        <label>End Time</label>
        <input type="datetime-local" name="end_time" class="form-control">
        <label>Status</label>
        <select name="status" class="form-control">
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button type="submit" name="add" class="btn btn-primary mt-3">Add Challenge</button>
    </div>
</form>
</div>
</div>

<!-- Existing Challenges -->
<div class="card mb-4">
<div class="card-header text-green">Existing Challenges</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="dataTable" width="100%" cellspacing="0">
<thead>
<tr>
    <th>ID</th>
    <th>Title</th>
    <th>Points</th>
    <th>Category</th>
    <th>Target</th>
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT c.*, t.name AS target_name FROM challenges c LEFT JOIN targets t ON c.target_id = t.id ORDER BY c.points ASC");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?php echo htmlentities($row['id']); ?></td>
    <td><?php echo htmlentities($row['title']); ?></td>
    <td><?php echo htmlentities($row['points']); ?></td>
    <td><?php echo htmlentities($row['category']); ?></td>
    <td><?php echo htmlentities($row['target_name']); ?></td>
    <td><?php echo htmlentities($row['status']); ?></td>
    <td>
        <button class="btn btn-info btn-sm" onclick="previewChallenge('<?php echo addslashes($row['title']); ?>','<?php echo addslashes($row['description']); ?>','<?php echo $row['points']; ?>','<?php echo $row['category']; ?>','<?php echo addslashes($row['target_name']); ?>')">Preview</button>
        <button class="btn btn-warning btn-sm" onclick="editChallenge('<?php echo $row['id']; ?>','<?php echo addslashes($row['title']); ?>','<?php echo addslashes($row['description']); ?>','<?php echo $row['points']; ?>','<?php echo $row['category']; ?>','<?php echo addslashes($row['flag']); ?>','<?php echo $row['status']; ?>','<?php echo $row['start_time']; ?>','<?php echo $row['end_time']; ?>','<?php echo $row['target_id']; ?>')">Edit</button>
        <a href="challenges.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
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

<!-- Preview Modal -->
<div class="modal fade" id="previewModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content bg-dark text-green">
<div class="modal-header"><h5 class="modal-title">Challenge Preview</h5></div>
<div class="modal-body">
    <p><strong>Title:</strong> <span id="previewTitle"></span></p>
    <p><strong>Description:</strong> <span id="previewDesc"></span></p>
    <p><strong>Points:</strong> <span id="previewPoints"></span></p>
    <p><strong>Category:</strong> <span id="previewCategory"></span></p>
    <p><strong>Target:</strong> <span id="previewTarget"></span></p>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
<div class="modal-dialog">
<div class="modal-content bg-dark text-green">
<form method="post">
<div class="modal-header"><h5 class="modal-title">Edit Challenge</h5></div>
<div class="modal-body">
    <input type="hidden" name="id" id="editId">
    <label>Title</label>
    <input type="text" name="title" id="editTitle" class="form-control" required>
    <label>Description</label>
    <textarea name="description" id="editDesc" class="form-control" required></textarea>
    <label>Points</label>
    <input type="number" name="points" id="editPoints" class="form-control" required>
    <label>Category</label>
    <input type="text" name="category" id="editCategory" class="form-control" required>
    <label>Flag</label>
    <input type="text" name="flag" id="editFlag" class="form-control" required>
    <label>Status</label>
    <select name="status" id="editStatus" class="form-control">
        <option value="active">Active</option>
        <option value="inactive">Inactive</option>
    </select>
    <label>Start Time</label>
    <input type="datetime-local" name="start_time" id="editStart" class="form-control">
    <label>End Time</label>
    <input type="datetime-local" name="end_time" id="editEnd" class="form-control">
    <label>Target</label>
    <select name="target_id" id="editTarget" class="form-control" required>
        <option value="">-- Select Target --</option>
        <?php
        $targets = mysqli_query($conn,"SELECT id, name FROM targets WHERE status='active'");
        while($t = mysqli_fetch_array($targets)){
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

<!-- JavaScript -->
<script>
function toggleAddForm() {
    const form = document.getElementById('addChallengeForm');
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

function toggleFlagInput() {
    const checkbox = document.getElementById('autoflag');
    const input = document.getElementById('flagInput');
    input.disabled = checkbox.checked;
    if (checkbox.checked) input.value = '';
}

function previewChallenge(title, desc, points, category, target) {
    document.getElementById('previewTitle').innerText = title;
    document.getElementById('previewDesc').innerText = desc;
    document.getElementById('previewPoints').innerText = points;
    document.getElementById('previewCategory').innerText = category;
    document.getElementById('previewTarget').innerText = target;
    new bootstrap.Modal(document.getElementById('previewModal')).show();
}

function editChallenge(id, title, desc, points, category, flag, status, start, end, target_id) {
    document.getElementById('editId').value = id;
    document.getElementById('editTitle').value = title;
    document.getElementById('editDesc').value = desc;
    document.getElementById('editPoints').value = points;
    document.getElementById('editCategory').value = category;
    document.getElementById('editFlag').value = flag;
    document.getElementById('editStatus').value = status;
    document.getElementById('editStart').value = start.replace(' ', 'T');
    document.getElementById('editEnd').value = end.replace(' ', 'T');
    document.getElementById('editTarget').value = target_id;
    new bootstrap.Modal(document.getElementById('editModal')).show();
}
</script>

<?php include 'footer.php'; ?>