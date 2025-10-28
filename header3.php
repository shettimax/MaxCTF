<?php include 'signature.php'; ?>
<?php 
ob_start();
error_reporting(0);
include 'confik.php';

$querysite = "SELECT * FROM site";
    $result = mysqli_query($conn,$querysite) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) 
    {
        while($row=mysqli_fetch_array($result))
        {
            $header=$row['header']; //description
            $header2=$row['header2']; //no pay needed
            $disclaimer=$row['disclaimer']; //disclaimer
            $about=$row['about']; //about
            $suna=$row['sitename']; //name
           
        }
    }

ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/x-icon" href="favi.ico">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Basic QUESTs for you" />
    <title>MAX CTF</title>
    <link href="css/hacker.css" rel="stylesheet">
    <link href="css/alert.css" rel="stylesheet">

    <style>
    .tall-row {
        margin-top: 40px;
    }
    .modal {
        position: relative;
        top: auto;
        right: auto;
        left: auto;
        bottom: auto;
        z-index: 1;
        display: block;
    }
    </style>
</head>

<body>
    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
    <li><a href="reg.php"><span class="text-green">SIGNUP</span></a></li>
    <li><a href="login.php"><span class="text-green">LOGIN</span></a></li>
    <li><a href="rankprogression.php"><span class="text-green">BADGES</span></a></li>
    <li>
        <a href="https://reddit.com/r/itsaunixsystem" target="_blank">
            <img src="img/donate.png" width="50" height="35" alt="Donor Badge" style="margin-bottom:5px;">
        </a>
    </li>
</ul>

            </div>
        </div>
    </nav>


    <div class="container">

        <!-- Jumbotron -->
         <?php
$currentPage = basename($_SERVER['PHP_SELF']);
$allowedPages = ['index.php']; // Add more as needed

if (!in_array($currentPage, $allowedPages)) {
?>
        <div class="jumbotron">
            <h1><?php echo $suna; ?></h1>
            <p><?php echo $header; ?> </p>
            <p><?php echo $header2; ?></p>
            <p>
                <a class="btn btn-lg btn-primary" href="home.php" role="button">proceed to site»</a>
            </p>
        </div>
<?php } ?>