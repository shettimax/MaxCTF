<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "IDOR";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

$id = isset($_GET['id']) ? $_GET['id'] : 1;
$res = mysqli_query($conn, "SELECT * FROM accounts WHERE id=$id");
$row = mysqli_fetch_assoc($res);
?>
<h2>IDOR View</h2>
<p>Account: <?php echo $row['username']; ?> | Balance: <?php echo $row['balance']; ?></p>
<?php echo $reportLink; ?>
