<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "XSS";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

if (isset($_POST['msg'])) {
  $sender = $_SESSION['ctfname'];
  $msg = $_POST['msg'];
  mysqli_query($conn, "INSERT INTO messages (sender, content) VALUES ('$sender', '$msg')");
}

$res = mysqli_query($conn, "SELECT * FROM messages");
?>
<h2>Stored XSS</h2>
<form method="POST">
  <textarea name="msg"></textarea><button>Send</button>
</form>
<ul>
<?php while ($row = mysqli_fetch_assoc($res)) {
  echo "<li><b>{$row['sender']}:</b> {$row['content']}</li>";
} ?>
</ul>
<?php echo $reportLink; ?>
