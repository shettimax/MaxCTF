<?php
ob_start();
include("session.php");
ini_set('display_errors', 0);
include 'confik.php';
include("header2.php");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Badges</title>
    <link rel="stylesheet" href="css/hackerr.css">
    <style>
        .badge-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .badge-card {
            background-color: #111;
            border: 1px solid #0f0;
            padding: 10px;
            text-align: center;
            width: 180px;
            box-shadow: 0 0 10px #0f0;
        }
        .badge-card img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .badge-card h4 {
            color: #0f0;
            font-size: 16px;
            margin: 0;
        }
        .badge-card p {
            color: #ccc;
            font-size: 12px;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <h1 style="color:#00ff99;">🏅Earned/Unlocked Badges</h1>
    <hr>
    <p><a href="javascript:history.back()" style="color:#0f0;">← Go Back</a></p>
    <div class="badge-grid">
    <?php
    $ctfscore = 0; // default for guests

if (!empty($_SESSION['id'])) {
    $ctfid = $_SESSION['id'];
    $userQuery = mysqli_query($conn, "SELECT ctfscore FROM accounts WHERE ctfid='$ctfid'");
    $userData = mysqli_fetch_assoc($userQuery);
    $ctfscore = $userData['ctfscore'];
}


    $sql = "SELECT id, title, vibe, required_score FROM badges ORDER BY id ASC";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $vibe = $row['vibe'];
            $required = $row['required_score'];

            echo "<div class='badge-card'>";

            if ($ctfscore >= $required) {
                // Unlocked badge
                $badgePath = "badges/$id.png";
                if (file_exists($badgePath)) {
                    $imageData = base64_encode(file_get_contents($badgePath));
                    $mimeType = mime_content_type($badgePath);
                    echo "<img src='data:$mimeType;base64,$imageData' alt='Badge $id'>";
                } else {
                    echo "<img src='assets/locked.png' alt='Badge Missing'>";
                }
                echo "<h4>" . htmlentities($title) . "</h4>";
                echo "<p>" . htmlentities($vibe) . "</p>";
            } else {
                // Locked badge
                $progress = round(($ctfscore / $required) * 100);
                echo "<i class='fa fa-lock fa-3x' style='color:#0f0;margin-bottom:10px;'></i>";
                echo "<h4 style='opacity:0.03;'>$title</h4>";
                echo "<p style='opacity:0.03;'>$vibe</p>";
                echo "<div style='background:#222;width:100%;height:10px;border-radius:5px;overflow:hidden;'>
                        <div style='width:$progress%;height:100%;background:#0f0;'></div>
                      </div>";
                echo "<p style='color:#0f0;font-size:11px;'>$ctfscore / $required → $progress%</p>";
            }

            echo "</div>";
        }
    } else {
        echo "<p>No badges found !.</p>";
    }
    ?>
</div>
    <p><a href="javascript:history.back()" style="color:#0f0;">← Go Back</a></p>
</body>
</html>
<?php include 'footer.php';
?>
