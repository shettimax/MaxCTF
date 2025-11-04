<?php
// Don't start session here - it's already started in the calling file
include 'config.php';

if (!isset($_SESSION['alogin']) || empty($_SESSION['alogin'])) {
    header('location:index.php');
    exit;
}

// Enhanced session security
$timeout = 1800;
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout) {
    session_unset();
    session_destroy();
    header("Location: index.php?timeout=1");
    exit;
}

$_SESSION['last_activity'] = time();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>M4XCTF BB</title>
    <link rel="icon" type="image/x-icon" href="/favi.ico">
    <link href="css/hacker.css" rel="stylesheet" />
    <link href="css/alert.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed" style="background-color: #000; color: #00ff99;">
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand text-green" href="dashboard.php">MAXCTFBB</a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link text-green" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</nav>
<div id="layoutSidenav">
<div id="layoutSidenav_nav">
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link text-green" href="dashboard.php"><i class="fas fa-terminal"></i> </a>|
            <a class="nav-link text-green" href="flags.php"><i class="fas fa-bug"></i> Flags</a>|
            <a class="nav-link text-green" href="ctflog.php"><i class="fas fa-history"></i> Flag History</a>|
            <a class="nav-link text-green" href="solves.php"><i class="fas fa-check-double"></i> Solves</a>|
            <a class="nav-link text-green" href="userz.php"><i class="fas fa-users"></i> Users</a>|
            <a class="nav-link text-green" href="badges.php"><i class="fas fa-award"></i> Badges</a>|
            <a class="nav-link text-green" href="challenges.php"><i class="fas fa-puzzle-piece"></i> Challenges</a>|
            <a class="nav-link text-green" href="targets.php"><i class="fas fa-crosshairs"></i> Targets</a>|
            <a class="nav-link text-green" href="modpanel.php"><i class="fas fa-user-shield"></i> Mod Panel</a>|
            <a class="nav-link text-green" href="analytics.php"><i class="fas fa-chart-bar"></i> Analytics</a>

            <div class="sb-sidenav-menu-heading text-green">|</div>
            <a class="nav-link text-green" href="addadmin.php"><i class="fas fa-user-plus"></i> Add Admin</a>|
            <a class="nav-link text-green" href="viewadmins.php"><i class="fas fa-users-cog"></i> View Admins</a>|
            <a class="nav-link text-green" href="auditlog.php"><i class="fas fa-clipboard-list"></i> Audit Log</a>|
        </div>
    </div>
</nav>
</div>
<div id="layoutSidenav_content">