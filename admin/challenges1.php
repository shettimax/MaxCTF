<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();

// Add challenge
if(isset($_POST['add'])){
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $points = $_POST['points'];
    $category = $_POST['category'];
    $flag = $_POST['flag'];
    $status = $_POST['status'];
    mysqli_query($conn,"INSERT INTO challenges (title, description, points, category, flag, status) VALUES ('$title','$desc','$points','$category','$flag','$status')");
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
<h1 class="mt-4"><i class="fas fa-puzzle-piece" style="margin-right: 5px;"></i>Challenge Manager</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Manage challenges</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Add New Challenge</div>
<div class="card-body">
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
        <input type="text" name="flag" class="form-control" required>
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
    <th>Status</th>
    <th>Action</th>
</tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT * FROM challenges ORDER BY points ASC");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?php echo htmlentities($row['id']); ?></td>
    <td><?php echo htmlentities($row['title']); ?></td>
    <td><?php echo htmlentities($row['points']); ?></td>
    <td><?php echo htmlentities($row['category']); ?></td>
    <td><?php echo htmlentities($row['status']); ?></td>
    <td><a href="challenges.php?del=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a></td>
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
