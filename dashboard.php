<?php
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
include 'confik.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$ctfid = $_SESSION['id'];
$query = mysqli_query($conn, "SELECT * FROM accounts WHERE ctfid='$ctfid'");
$data = mysqli_fetch_assoc($query);

$ctfname = $data['ctfname'];
$ctfscore = $data['ctfscore'];
// Get current badge
$currentBadgeQuery = mysqli_query($conn, "
    SELECT * FROM badges 
    WHERE required_score <= $ctfscore 
    ORDER BY required_score DESC 
    LIMIT 1
");
$currentBadge = mysqli_fetch_assoc($currentBadgeQuery);

// Get next badge
$nextBadgeQuery = mysqli_query($conn, "
    SELECT * FROM badges 
    WHERE required_score > $ctfscore 
    ORDER BY required_score ASC 
    LIMIT 1
");
$nextBadge = mysqli_fetch_assoc($nextBadgeQuery);

// Progress calculation
$progress = 0;
if ($nextBadge) {
    $start = $currentBadge['required_score'];
    $end = $nextBadge['required_score'];
    $progress = round((($ctfscore - $start) / ($end - $start)) * 100);
}

$joined = $data['joined'];
$ctfskillset = $data['ctfskillset'];
$gender = $data['gender'];
$ctfemail = $data['ctfemail'];
ob_end_flush();
?>

<?php include 'header2.php'; ?>

<div class="col-md-4">
    <h3>MAXCTF Dashboard</h3>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#home" data-toggle="tab">Home</a></li>
        <li><a href="#profile" data-toggle="tab">Progress</a></li>
        <li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">More <span class="caret"></span></a>
            <ul class="dropdown-menu">
                <li><a href="#dropdown1" data-toggle="tab">Leaderboard</a></li>
                <li class="divider"></li>
                <li><a href="#dropdown2" data-toggle="tab">Submit Report</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><b>./exit</b></a></li>
            </ul>
        </li>
    </ul>

    <div id="myTabContent" class="tab-content">
        <div class="tab-pane fade active in" id="home">
    <div class="alert alert-dismissible alert-success">
        <a href="#" class="close" style="text-decoration:none;">*</a>
        <hr>
        <img src="static.webp" width="110" height="110">
        <h2 style="color:#080808;"><?php echo htmlentities($ctfname); ?></h2>
        <hr>
        <p><?php
        $quoteQuery = mysqli_query($conn, "SELECT quote FROM quotes ORDER BY RAND() LIMIT 1");
        $quoteRow = mysqli_fetch_assoc($quoteQuery);
        if ($quoteRow) {
            echo "<p class='text-center'><code>“" . htmlentities($quoteRow['quote']) . "”</code></p>";
        }
        ?>
        </p>
        <div class="badge-preview">
    <h5 style="color:#00ff99;">⭐RANK</h5>
    <p><strong><?php echo $currentBadge['title']; ?></strong></p>

    
</div>

        <hr>
    </div>
</div>


        <div class="tab-pane fade" id="profile">
    <div class="alert alert-dismissible alert-info">
        <a href="#" class="close" style="text-decoration:none;">*</a>
        <hr>
        <p>
        </p>
        <div class="badge-preview">
            <h5>🎖️[CURRENTBADGE]</h5>
            <?php
$badgePath = "badges/" . $currentBadge['id'] . ".png"; // or .jpg if needed
if (file_exists($badgePath)) {
    $imageData = base64_encode(file_get_contents($badgePath));
    $mimeType = mime_content_type($badgePath);
    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" width="100" alt="Badge" title="earned not given">';
} else {
    echo '<img src="favi.ico" width="100" alt="Locked Badge">';
}
?>

            <p style="color:#080808;"><strong><?php echo $currentBadge['title']; ?></strong> — <?php echo $currentBadge['vibe']; ?></p>

            <?php if ($nextBadge): ?>
                <p>Next Badge: <strong style="opacity:0.12;"><?php echo $nextBadge['title']; ?></strong> @<?php echo $nextBadge['required_score']; ?> pts</p>
                <div style="background:#eee;width:100%;height:20px;border-radius:10px;overflow:hidden;">
                    <div style="width:<?php echo $progress; ?>%;height:100%;background:#4caf50;"></div>
                </div>
                <p><?php echo $ctfscore; ?> / <?php echo $nextBadge['required_score']; ?> → <?php echo $progress; ?>% complete</p>
            <?php else: ?>
                <p style="color:#6B8E23;">🎉Congratulations <b><?php echo htmlentities($ctfname); ?></b> You've reached the highest badge: <strong><?php echo $currentBadge['title']; ?></strong>!</p>
            <?php endif; ?>
        </div>
    </div>
</div>


        <div class="tab-pane fade" id="dropdown1">
            <p>Your Score: <strong><?php echo $ctfscore; ?> pts</strong><br>
            Top 5 Hackers:</p>
            <?php
            $top = mysqli_query($conn, "SELECT ctfid, ctfscore FROM accounts ORDER BY ctfscore DESC LIMIT 5");
            while ($row = mysqli_fetch_assoc($top)) {
                echo "<p><strong>" . htmlentities($row['ctfid']) . "</strong>: " . htmlentities($row['ctfscore']) . " pts</p>";
            }
            ?>
            <p>See full board <a href="rankprogression.php">here</a></p>
        </div>

        <div class="tab-pane fade" id="dropdown2">
            <p>Need more points? Capture flags & submit <a href="profile.php">here</a><br>
            Or goto <code>cmVwb3J0ZXI=</code>.php<br>
            Points will be rewarded once verified.</p>
            <h5 style="color:#00ff99;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;[<b>RECENT FLAG SUBMISSIONS</b>]</h5>
            <ul class="list-group">
            <?php
            $feed = mysqli_query($conn, "SELECT date, bug, severity, amount, status FROM reportx WHERE walletid='$ctfid' ORDER BY date DESC LIMIT 5");
            while ($row = mysqli_fetch_assoc($feed)) {
                $tag = ($row['status'] === 'approved') ? '✔' : '✖';
                echo "<li class='list-group-item'>[$tag] " . htmlentities($row['date']) . " flagged <em>" . htmlentities($row['bug']) . "</em> (" . htmlentities($row['severity']) . ") — <span class='badge'>" . htmlentities($row['amount']) . " pts</span></li>";
            }
            ?>
            </ul>
        </div>
    </div><hr>
</div>
<div class="alert alert-dismissible alert-success">
    <h4>⭐</h4><a href="#" class="close" style="text-decoration:none;">#</a>
    <hr>
    <p>
            <span style="color:#00ff99;">CTFID:</span>
                <strong> &nbsp;&nbsp;&nbsp;<?php echo htmlentities($ctfid); ?></strong><br>
            <span style="color:#00ff99;">JOINED:</span>
            <strong> &nbsp;&nbsp;<?php echo htmlentities($joined); ?></strong> <i style="color:#00ff99;">As a</i> <strong><?php echo htmlentities($ctfskillset); ?></strong><br>
            <span style="color:#00ff99;">GENDER:</span>
            <strong> &nbsp;&nbsp;<?php echo htmlentities($gender); ?></strong><br>
            <span style="color:#00ff99;">EMAIL:</span>
            <strong> &nbsp;&nbsp;&nbsp;<?php echo htmlentities($ctfemail); ?></strong><br>
            <span style="color:#00ff99;">SKILLSET:</span>
            <strong> <?php echo htmlentities ($currentBadge['title']); ?></strong><br>
            <span style="color:#00ff99;">CTFScore:</span>
            <strong> <?php echo htmlentities($ctfscore); ?></strong>pts
    </p>
    <hr>
    <div class="badge-preview">
        <h5 style="color:#00ff99;">🎖️<b>BADGE</b></h5>
        <?php
$badgePath = "badges/" . $currentBadge['id'] . ".png"; // or .jpg if needed
if (file_exists($badgePath)) {
    $imageData = base64_encode(file_get_contents($badgePath));
    $mimeType = mime_content_type($badgePath);
    echo '<img src="data:' . $mimeType . ';base64,' . $imageData . '" width="110" alt="Badge" title="' . htmlentities($currentBadge['title']) . '">';
} else {
    echo '<img src="favi.ico" width="110" alt="Locked Badge">';
}
?>
 
        |<b><?php echo $currentBadge['vibe']; ?></b>
    </div>
</div>
<?php include 'footer.php'; ?>
