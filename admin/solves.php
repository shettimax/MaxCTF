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
<h1 class="mt-4"><i class="fas fa-flag-checkered" style="margin-right: 5px;"></i>Challenge Solves</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Solve history</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Recent Solves</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="dataTable" width="100%" cellspacing="0">
<thead>
<tr>
    <th>CTFID</th>
    <th>Player</th>
    <th>Challenge</th>
    <th>Points</th>
    <th>Category</th>
    <th>Solved At</th>
</tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"
    SELECT s.ctfid, a.ctfname, c.title, c.points, c.category, s.timestamp 
    FROM solves s 
    JOIN accounts a ON s.ctfid = a.ctfid 
    JOIN challenges c ON s.challenge_id = c.id 
    ORDER BY s.timestamp DESC
");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?php echo htmlentities($row['ctfid']); ?></td>
    <td><?php echo htmlentities($row['ctfname']); ?></td>
    <td><?php echo htmlentities($row['title']); ?></td>
    <td><?php echo htmlentities($row['points']); ?></td>
    <td><?php echo htmlentities($row['category']); ?></td>
    <td><?php echo htmlentities($row['timestamp']); ?></td>
</tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>

<div class="card mb-4">
<div class="card-header text-green">Top Solvers (by # of solves)</div>
<div class="card-body">
<table class="table table-bordered text-green">
<thead><tr><th>CTFID</th><th>Name</th><th>Total Solves</th></tr></thead>
<tbody>
<?php
$top = mysqli_query($conn,"
    SELECT s.ctfid, a.ctfname, COUNT(*) as total 
    FROM solves s 
    JOIN accounts a ON s.ctfid = a.ctfid 
    GROUP BY s.ctfid 
    ORDER BY total DESC 
    LIMIT 10
");
while($row = mysqli_fetch_array($top)){
    echo "<tr><td>".htmlentities($row['ctfid'])."</td><td>".htmlentities($row['ctfname'])."</td><td>".htmlentities($row['total'])."</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div>
</main>
<?php include 'footer.php'; ?>
