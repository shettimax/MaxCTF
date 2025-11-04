<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "Manipulation";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

$res = mysqli_query($conn, "SELECT * FROM products");
?>
<h2>Logic Flaw: Price Manipulation</h2>
<ul>
<?php while ($row = mysqli_fetch_assoc($res)) {
  echo "<li>{$row['name']} - ₦{$row['price']}</li>";
} ?>
</ul>
<?php echo $reportLink; ?>
