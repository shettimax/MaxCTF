<?php
ob_start();
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
        <li><a href="#profile" data-toggle="tab">Profile</a></li>
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
        <h2><?php echo htmlentities($ctfname); ?></h2>
        <hr>
        <p>
            CTFID:<strong> <?php echo htmlentities($ctfid); ?></strong><br>
            Joined:<strong> <?php echo htmlentities($joined); ?></strong> As a<strong> <?php echo htmlentities($ctfskillset); ?></strong><br>
            Email:<strong> <?php echo htmlentities($ctfemail); ?></strong> CTFScore:<strong><?php echo htmlentities($ctfscore); ?></strong>
            <br>
        </p>
        <div class="badge-preview">
    <h5>🎖️ Badge</h5>
    <img src="badges/<?php echo $currentBadge['id']; ?>.png" alt="Badge" title="earned not given" width="100">
    <p><strong><?php echo $currentBadge['title']; ?></strong> — <?php echo $currentBadge['vibe']; ?></p>

    <?php if ($nextBadge): ?>
        <p>Next Badge: <strong><?php echo $nextBadge['title']; ?></strong> @<?php echo $nextBadge['required_score']; ?> pts</p>
        <div style="background:#eee;width:100%;height:20px;border-radius:10px;overflow:hidden;">
            <div style="width:<?php echo $progress; ?>%;height:100%;background:#4caf50;"></div>
        </div>
        <p><?php echo $ctfscore; ?> / <?php echo $nextBadge['required_score']; ?> → <?php echo $progress; ?>% complete</p>
    <?php else: ?>
        <p>🎉 You've reached the highest badge: <strong><?php echo $currentBadge['title']; ?></strong>!</p>
    <?php endif; ?>
</div>

        <hr>
        <?php
        $quoteQuery = mysqli_query($conn, "SELECT quote FROM quotes ORDER BY RAND() LIMIT 1");
        $quoteRow = mysqli_fetch_assoc($quoteQuery);
        if ($quoteRow) {
            echo "<p class='text-center'><code>“" . htmlentities($quoteRow['quote']) . "”</code></p>";
        }
        ?>
    </div>
</div>


        <div class="tab-pane fade" id="profile">
            <p><img src="http://shettima.xtgem.com/images/ion.png" width="50" height="50" alt="user" /><br>
            > <?php echo $ctfname; ?> (<?php echo $gender; ?>)<br>
            > <?php echo $ctfid; ?> (<?php echo $ctfskillset; ?>)<br>
            > Joined: <u><?php echo $joined; ?></u><br>
            > Email: <u><?php echo $ctfemail; ?></u></p>
        </div>

        <div class="tab-pane fade" id="dropdown1">
            <p>Your Score: <strong><?php echo $ctfscore; ?> pts</strong><br>
            Top 3 Hackers:</p>
            <?php
            $top = mysqli_query($conn, "SELECT ctfid, ctfscore FROM accounts ORDER BY ctfscore DESC LIMIT 3");
            while ($row = mysqli_fetch_assoc($top)) {
                echo "<p><strong>" . htmlentities($row['ctfid']) . "</strong>: " . htmlentities($row['ctfscore']) . " pts</p>";
            }
            ?>
            <p>See full board <a href="leadershipboard.php">here</a></p>
        </div>

        <div class="tab-pane fade" id="dropdown2">
            <p>Need more points? Capture flags & submit <a href="profile.php">here</a><br>
            Or crack <code>cmVwb3J0ZXI=</code> (.php)<br>
            Points will be rewarded once verified.</p>
            <h5>📡 Recent Flag Submissions</h5>
            <ul class="list-group">
            <?php
            $feed = mysqli_query($conn, "SELECT walletid, bug, severity, amount, status FROM reportx ORDER BY id DESC LIMIT 5");
            while ($row = mysqli_fetch_assoc($feed)) {
                $tag = ($row['status'] === 'approved') ? '✔' : '✖';
                echo "<li class='list-group-item'>[$tag] " . htmlentities($row['walletid']) . " flagged <em>" . htmlentities($row['bug']) . "</em> (" . htmlentities($row['severity']) . ") — <span class='badge'>" . htmlentities($row['amount']) . " pts</span></li>";
            }
            ?>
            </ul>
        </div>
    </div><hr>
</div>
<?php include 'footer.php'; ?>
