<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "XSS";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

$q = isset($_GET['q']) ? $_GET['q'] : '';
?>
<h2>Reflected XSS</h2>
<form method="GET">
  <input name="q" placeholder="Search"><button>Go</button>
</form>
<?php if ($q) echo "<p>Results for: $q</p>"; ?>
<?php echo $reportLink; ?>
