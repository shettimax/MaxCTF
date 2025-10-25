<?php
session_start();
include("confik.php");
include("header2.php");

if (!isset($_GET['ctfid'])) {
    echo "<div class='alert alert-danger'>No user specified.</div>";
    exit();
}

$ctfid = mysqli_real_escape_string($conn, $_GET['ctfid']);
$query = mysqli_query($conn, "SELECT * FROM accounts WHERE ctfid = '$ctfid'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Whois: <?php echo htmlentities($user['ctfname']); ?></title>
    <link rel="stylesheet" href="css/hacker.css">
    <link rel="stylesheet" href="css/alert.css">
    <style>
        body {
            background-color: #000;
            color: #0f0;
            font-family: monospace;
            padding: 40px;
        }
        .alert {
            max-width: 600px;
            margin: auto;
            box-shadow: 0 0 15px #0f0;
        }
        .alert h4 {
            font-size: 20px;
        }
        .alert p {
            font-size: 14px;
        }
        .badge-preview {
            margin-top: 15px;
            text-align: center;
        }
        .badge-preview img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            box-shadow: 0 0 10px #0f0;
        }
    </style>
</head>
<body>

<div class="alert alert-dismissible alert-success">
    <h4><u>WHOAMI;</u></h4><a href="home.php" class="close" style="text-decoration:none;">BACK</a>
    <hr>
    <img src="static.webp" width="110" height="110"><br>
    <h2><?php echo htmlentities($user['ctfname']); ?></h2>
    <p>
        CTFID:<strong> <?php echo htmlentities($user['ctfid']); ?></strong><br>
        Joined:<strong> <?php echo htmlentities($user['joined']); ?></strong><br>
        CTFScore:<strong> <?php echo htmlentities($user['ctfscore']); ?></strong><br>
        Skillset:<strong> <?php echo htmlentities($user['ctfskillset']); ?></strong><br>
    </p>
    <div class="badge-preview">
        <h5>🎖️ Badge</h5>
        <img src="badges/<?php echo $user['badge_id']; ?>.png" alt="Badge">
    </div>
</div>

</body>
</html>

<?php include("footer.php"); ?>
