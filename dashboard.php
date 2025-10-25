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
            <p><strong>👋 Welcome back, <?php echo strtoupper($ctfname); ?>!</strong><br>
<?php
$quoteQuery = mysqli_query($conn, "SELECT quote FROM quotes ORDER BY RAND() LIMIT 1");
$quoteRow = mysqli_fetch_assoc($quoteQuery);
if ($quoteRow) {
    echo "<p class='text-center'><code>“" . htmlentities($quoteRow['quote']) . "”</code></p>";
}
?>

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
