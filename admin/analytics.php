<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-chart-bar" style="margin-right: 5px;"></i>Flag Analytics</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">CTF stats and breakdowns</li>
</ol>

<div class="row">

<!-- Top Bugs -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Most Reported Bugs</div>
<div class="card-body">
<table class="table table-bordered text-green">
<thead><tr><th>Bug</th><th>Count</th></tr></thead>
<tbody>
<?php
$bug_query = mysqli_query($conn,"SELECT bug, COUNT(*) as count FROM reportx WHERE status='approved' GROUP BY bug ORDER BY count DESC");
while($row = mysqli_fetch_array($bug_query)){
    echo "<tr><td>".htmlentities($row['bug'])."</td><td>".htmlentities($row['count'])."</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>

<!-- Severity Breakdown -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Severity Breakdown</div>
<div class="card-body">
<table class="table table-bordered text-green">
<thead><tr><th>Severity</th><th>Count</th></tr></thead>
<tbody>
<?php
$severity_query = mysqli_query($conn,"SELECT severity, COUNT(*) as count FROM reportx WHERE status='approved' GROUP BY severity ORDER BY count DESC");
while($row = mysqli_fetch_array($severity_query)){
    echo "<tr><td>".htmlentities($row['severity'])."</td><td>".htmlentities($row['count'])."</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>

<!-- Top Solvers -->
<div class="col-xl-12 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Top Solvers</div>
<div class="card-body">
<table class="table table-bordered text-green">
<thead><tr><th>CTFID</th><th>Name</th><th>Score</th></tr></thead>
<tbody>
<?php
$top_query = mysqli_query($conn,"SELECT ctfid, ctfname, ctfscore FROM accounts ORDER BY ctfscore DESC LIMIT 10");
while($row = mysqli_fetch_array($top_query)){
    echo "<tr><td>".htmlentities($row['ctfid'])."</td><td>".htmlentities($row['ctfname'])."</td><td>".htmlentities($row['ctfscore'])."</td></tr>";
}
?>
