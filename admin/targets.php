<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();

// Add target
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $path = $_POST['path'];
    $status = $_POST['status'];
    $difficulty = $_POST['difficulty'];
    $category = $_POST['category'];
    mysqli_query($conn,"INSERT INTO targets (name, path, status, difficulty, category) VALUES ('$name','$path','$status','$difficulty','$category')");
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
<h1 class="mt-4"><i class="fas fa-crosshairs" style="margin-right: 5px;"></i>Target Manager</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage vulnerable apps</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Add New Target</div>
<div class="card-body">
<form method="post">
    <div class="form-group">
        <label>Name</label>
        <input type="text" name="name" class="form-control" required>
        <label>Path</label>
        <input type="text" name="path" class="form-control" required>
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
        <input type="text" name="category" class="form-control" required>
        <button type="submit" name="add" class="btn btn-primary mt-3">Add Target</button>
    </div>
</form>
</div>
</div>

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
    <td><a href="targets.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</main>
<?php include 'footer2.php'; ?>
