<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "CSRF";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

if (isset($_POST['transfer'])) {
  $to = $_POST['to'];
  $amount = $_POST['amount'];
  mysqli_query($conn, "UPDATE accounts SET balance = balance + $amount WHERE username='$to'");
}
?>
<h2>CSRF Transfer</h2>
<form method="POST">
  <input name="to" placeholder="Recipient"><input name="amount" placeholder="Amount">
  <button name="transfer">Transfer</button>
</form>
<?php echo $reportLink; ?>
