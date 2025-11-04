<?php
include("../../../session.php");
include("../db.php");

$bugType = isset($_GET['bugx']) ? $_GET['bugx'] : "SQLi";
$reportLink = '<a href="../../../ctfreporter.php?bugx=' . urlencode($bugType) . '" class="btn btn-primary">📝 Report This Bug</a>';

if (!isset($_SESSION['id'])) { header("Location: ../../../login.php"); exit(); }

if (isset($_POST['login'])) {
  $u = $_POST['username'];
  $p = $_POST['password'];
  $sql = "SELECT * FROM users WHERE username='$u' AND password='$p'";
  $res = mysqli_query($conn, $sql);
  $msg = (mysqli_num_rows($res) > 0) ? "Welcome $u!" : "Login failed.";
}
?>
<h2>SQL Injection</h2>
<form method="POST">
  <input name="username"><input name="password"><button name="login">Login</button>
</form>
<?php if (isset($msg)) echo "<p>$msg</p>"; ?>
<?php echo $reportLink; ?>
