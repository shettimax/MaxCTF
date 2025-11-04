<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "UPLOADer";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

if (isset($_POST['upload'])) {
  $name = basename($_FILES['file']['name']);
  move_uploaded_file($_FILES['file']['tmp_name'], "uploads/$name");
}
?>
<h2>File Upload</h2>
<form method="POST" enctype="multipart/form-data">
  <input type="file" name="file"><button name="upload">Upload</button>
</form>
<?php echo $reportLink; ?>
