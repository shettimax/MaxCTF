<?php
session_start();
include("confik.php");
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
    <h1>🏅CTF Badges</h1>
    <div class="badge-grid">
        <?php
        $sql = "SELECT id, title, vibe FROM badges ORDER BY id ASC";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = $row['title'];
                $vibe = $row['vibe'];
                echo "<div class='badge-card'>
                        <img src='badges/$id.png' alt='Badge $id'>
                        <h4>$title</h4>
                        <p>$vibe</p>
                      </div>";
            }
        } else {
            echo "<p>No badges found.</p>";
        }
        ?>
    </div>
</body>
</html>
<?php include 'footer.php';
?>
