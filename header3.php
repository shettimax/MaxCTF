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
            $header=$row['header']; //main balance
            $header2=$row['header2']; //main balance
            $disclaimer=$row['disclaimer']; //fetch colmn username  so2 echo l8r
            $about=$row['about']; //join 1st n last name of user
            $suna=$row['sitename']; //join 1st n last name of user
           
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

    <a href="#"><img style="position: absolute; top: 0; left: 0; border: 0;z-index:1001;" src="img/mfork.png" alt=""></a>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html#">1337@n00bs ~ $</a>
            </div>
            <div id="navbar" class="navbar-collapse collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown">
                        <a xhref="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">CLICK ME!!!<span class="caret"></span> </a>
                    </li>
                    <li>
                        <a href="https://reddit.com/r/itsaunixsystem" target="_blank">H4x0rs Only</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container">

        <!-- Jumbotron -->
        <div class="jumbotron">
            <h1><?php echo $suna; ?></h1>
            <p><?php echo $header; ?> </p>
            <p><?php echo $header2; ?></p>
            <p>
                <a class="btn btn-lg btn-primary" href="home.php" role="button">proceed to site»</a>
            </p>
        </div>
