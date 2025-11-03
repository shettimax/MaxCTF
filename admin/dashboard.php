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

<!-- Flags Overview -->
<div class="col-xl-3 col-md-6">
<div class="card bg-dark text-green mb-4">
<div class="card-body">
<?php
$pending = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM reportx WHERE status='pending'"));
$approved = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM reportx WHERE status='approved'"));
$rejected = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM reportx WHERE status='rejected'"));
$totalFlags = $pending + $approved + $rejected;
?>
<div style="font-size: 20px;"><i class="fas fa-flag"></i> Flags (<?= $totalFlags ?>)</div>
<div style="font-size: 13px;" class="mt-2">
🕓 Pending: <?= $pending ?><br>
✅ Approved: <?= $approved ?><br>
❌ Rejected: <?= $rejected ?>
</div>
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

<!-- Recent Admin Actions -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Recent Admin Actions</div>
<div class="card-body">
<ul class="list-group list-group-flush">
<?php
$logs = mysqli_query($conn,"SELECT * FROM auditlog ORDER BY id DESC LIMIT 5");
while($log = mysqli_fetch_array($logs)){
    echo "<li class='list-group-item bg-dark text-green border-secondary'>{$log['admin']} — {$log['action']}</li>";
}
?>
</ul>
</div>
</div>
</div>

<!-- Recent Flag Submissions (with missing header for Status) -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Recent Flag Submissions</div>
<div class="card-body">
<table class="table table-sm table-dark table-bordered">
<thead><tr><th>User</th><th>Bug</th></tr></thead>
<tbody>
<?php
$recentFlags = mysqli_query($conn,"SELECT walletid, bug, status FROM reportx ORDER BY id DESC LIMIT 5");
while($row = mysqli_fetch_array($recentFlags)){
    echo "<tr><td>{$row['walletid']}</td><td>{$row['bug']}</td><td>{$row['status']}</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>
</div>

<!-- Top Scorers -->
<div class="col-xl-6 col-md-12">
<div class="card bg-dark text-green mb-4">
<div class="card-header">Top 5 Users by Score</div>
<div class="card-body">
<ol class="mb-0">
<?php
$top = mysqli_query($conn,"SELECT ctfid, ctfscore FROM accounts ORDER BY ctfscore DESC LIMIT 5");
while($user = mysqli_fetch_array($top)){
    echo "<li>{$user['ctfid']} — {$user['ctfscore']} pts</li>";
}
?>
</ol>
</div>
</div>
</div>

</div>
</main>
<?php include 'footer.php'; ?>
