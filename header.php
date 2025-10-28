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
            $header=$row['header']; //mainheadsys
            $header2=$row['header2']; //fetch header na biyu
            $disclaimer=$row['disclaimer']; //fetch discliamer info
            $about=$row['about']; //fetch aboutinfo
            $suna=$row['sitename']; //fetch sitname
           
        }
    }

ob_end_flush();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="favi.ico">

    <title>M4X QUEST</title>
    <link href="css/hacker.css" rel="stylesheet">
      <link rel="stylesheet" href="css/alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

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
                <a class="btn btn-lg btn-primary" href="https://t.me/mazangizo" role="button">Contact »</a>
            </p>
        </div>
