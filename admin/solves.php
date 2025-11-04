<?php
ob_start();
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
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
    $ctfid = htmlspecialchars($row['ctfid'], ENT_QUOTES, 'UTF-8');
    $ctfname = htmlspecialchars($row['ctfname'], ENT_QUOTES, 'UTF-8');
    $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
    $points = intval($row['points']);
    $category = htmlspecialchars($row['category'], ENT_QUOTES, 'UTF-8');
    $timestamp = htmlspecialchars($row['timestamp'], ENT_QUOTES, 'UTF-8');
?>
<tr>
    <td><?php echo $ctfid; ?></td>
    <td><?php echo $ctfname; ?></td>
    <td><?php echo $title; ?></td>
    <td><?php echo $points; ?></td>
    <td><?php echo $category; ?></td>
    <td><?php echo $timestamp; ?></td>
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
<thead>
    <tr>
        <th>CTFID</th>
        <th>Name</th>
        <th>Total Solves</th>
    </tr>
</thead>
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
    $ctfid = htmlspecialchars($row['ctfid'], ENT_QUOTES, 'UTF-8');
    $ctfname = htmlspecialchars($row['ctfname'], ENT_QUOTES, 'UTF-8');
    $total = intval($row['total']);
    echo "<tr><td>$ctfid</td><td>$ctfname</td><td>$total</td></tr>";
}
?>
</tbody>
</table>
</div>
</div>

</div>
</main>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable({
        pageLength: 50,
        order: [[5, 'desc']]
    });
});
</script>

<?php include 'footer.php'; ?>