<?php
ob_start();
include("session.php");
ini_set('display_errors', 0);
include 'confik.php';
include("header2.php");

if (!isset($_GET['ctfid'])) {
    echo "<div class='alert alert-danger'>No user specified.</div>";
    exit();
}

//Get the ctf person
$ctfid = mysqli_real_escape_string($conn, $_GET['ctfid']);
$query = mysqli_query($conn, "SELECT * FROM accounts WHERE ctfid = '$ctfid'");
$user = mysqli_fetch_assoc($query);

if (!$user) {
    echo "<div class='alert alert-danger'>User not found.</div>";
    exit();
}

// Get current badge
$ctfscore = (int)$user['ctfscore'];
$currentBadgeQuery = mysqli_query($conn, "
    SELECT * FROM badges 
    WHERE required_score <= $ctfscore 
    ORDER BY required_score DESC 
    LIMIT 1
");
$currentBadge = mysqli_fetch_assoc($currentBadgeQuery);
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
    <a href="home.php" class="close" style="text-decoration:none;">BACK</a>
    <hr>
    <img src="img/profile/1.png" width="110" height="110"><br>
    <h2 style="color:#080808;"><?php echo htmlentities($user['ctfname']); ?></h2>
    <p>
        <span style="color:#00ff99;">CTFID:</span>
            <strong> <?php echo htmlentities($user['ctfid']); ?></strong><br>
        <span style="color:#00ff99;">Joined:</span>
            <strong> <?php echo htmlentities($user['joined']); ?></strong><br>
        <span style="color:#00ff99;">CTFScore:</span>
            <strong> <?php echo htmlentities($user['ctfscore']); ?></strong>pts<br>
        <span style="color:#00ff99;">Rank:</span>
            <strong> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo htmlentities($currentBadge['title']); ?></strong><br>
    </p>
    <div class="badge-preview">
        <h5>🎖️ Badge</h5>
        <?php
$badgePath = "badges/" . $currentBadge['id'] . ".png";
if (file_exists($badgePath)) {
    $imageData = base64_encode(file_get_contents($badgePath));
    $mimeType = mime_content_type($badgePath);
    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" alt="Badge" title="' . htmlentities($currentBadge['vibe']) . '">';
} else {
    echo '<img src="favi.ico" alt="Badge Missing">';
}
?>

    </div>
</div>
<p>
    <a href="javascript:history.back()" style="color:#0f0;">← Go Back</a>
</p>

</body>
</html>

<?php include("footer.php"); ?>
