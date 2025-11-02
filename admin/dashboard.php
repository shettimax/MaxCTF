<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0 || $_SESSION['role'] != 'admin'){
    header('location:index.php');
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-terminal"></i> Dashboard</h1>
<div class="row">

<!-- Total Users -->
<div class="col-xl-3 col-md-6">
<div class="card bg-dark text-green mb-4">
<div class="card-body"><i class="fas fa-users"></i> Total Users
<?php $rowcount = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM accounts")); ?>
<div style="font-size: 20px;"><?php echo $rowcount; ?></div>
</div>
</div>
</div>

<!-- Pending Flags -->
<div class="col-xl-3 col-md-6">
<div class="card bg-dark text-green mb-4">
<div class="card-body"><i class="fas fa-bug"></i> Pending Flags
<?php $rowcount = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM reportx WHERE status='pending'")); ?>
<div style="font-size: 20px;"><?php echo $rowcount; ?></div>
</div>
</div>
</div>

<!-- Skillset Breakdown -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Skillset Distribution</div>
<div class="card-body">
<?php
$skills = mysqli_query($conn,"SELECT ctfskillset, COUNT(*) as count FROM accounts GROUP BY ctfskillset");
while($row = mysqli_fetch_array($skills)){
    echo "<div>" . htmlentities($row['ctfskillset']) . ": " . htmlentities($row['count']) . "</div>";
}
?>
</div>
</div>
</div>

<!-- Badge Distribution -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Badge Distribution</div>
<div class="card-body">
<?php
$badges = mysqli_query($conn,"SELECT title, COUNT(*) as count FROM badges GROUP BY title");
while($row = mysqli_fetch_array($badges)){
    echo "<div>" . htmlentities($row['title']) . ": " . htmlentities($row['count']) . "</div>";
}
?>
</div>
</div>
</div>

</div>
</main>
<?php include 'footer2.php'; ?>
