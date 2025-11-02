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
<link rel="stylesheet" href="alert.css">
<link rel="stylesheet" href="hacker.css">
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-bug"></i> Flag Approval</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Verify submitted flags</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Pending Flags</div>
<div class="card-body">
<div class="table-responsive" id="flagTable">
<!-- Table loads via AJAX -->
</div>
</div>
</div>
</div>
</main>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="control.js"></script>
<?php include 'footer2.php'; ?>

