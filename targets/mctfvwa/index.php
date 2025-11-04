<?php
include("../../session.php");
if (!isset($_SESSION['id']) || !isset($_SESSION['ctfname'])) {
  header("Location: ../../login.php");
  exit();
}

$ctfname = $_SESSION['ctfname'];
$ctfid = $_SESSION['ctfid'];
$categories = ['auth', 'csrf', 'idor', 'logic', 'sqli', 'upload', 'xss'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>MCTFVWA Lab</title>
  <link rel="stylesheet" href="../../css/hacker.css">
  <link rel="stylesheet" href="../../css/alert.css">
</head>
<body>
  <div class="container">
    <h2>Welcome, <?php echo htmlentities($ctfname); ?> (<?php echo htmlentities($ctfid); ?>)</h2>
    <hr>
    <h3>🧪 Available Challenges</h3>
    <ul>
      <?php
      foreach ($categories as $cat) {
        $path = __DIR__ . "/$cat";
        if (is_dir($path)) {
          $files = glob("$path/*.php");
          foreach ($files as $file) {
            $name = basename($file, ".php");
            echo "<li><a href='$cat/$name.php'>[$cat] $name</a></li>";
          }
        }
      }
      ?>
    </ul>
    <hr>
    <p><a href="../../dashboard.php">🔙 Back to Profile</a></p>
  </div>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="#" class="report-link">📝 Report a Bug</a>

<!-- Report Modal (shared) -->
<div id="reportModal" class="report-modal" style="display:none;">
  <div class="report-modal-content">
    <h3 class="report-modal-title">Report This Bug</h3>
    <p class="report-modal-body">You are about to leave the lab and open the in-dashboard reporter. it's expected you have POC's !! Continue?</p>
    <div class="report-modal-actions">
      <button id="reportCancel" class="btn btn-secondary">NO</button>
      <button id="reportConfirm" class="btn btn-primary">YES</button>
    </div>
  </div>
</div>
<script>
// Simple modal logic (no external libs)
(function(){
  function showReportModal() {
    var m = document.getElementById('reportModal');
    if (!m) return false;
    m.style.display = 'block';
  }
  function hideReportModal() {
    var m = document.getElementById('reportModal');
    if (!m) return false;
    m.style.display = 'none';
  }
  window.addEventListener('load', function(){
    document.body.addEventListener('click', function(e){
      var t = e.target || e.srcElement;
      if (t && t.matches && t.matches('.report-link')) {
        e.preventDefault();
        showReportModal();
      }
    });
    var cancel = document.getElementById('reportCancel');
    var confirm = document.getElementById('reportConfirm');
    if (cancel) cancel.addEventListener('click', hideReportModal);
    if (confirm) confirm.addEventListener('click', function(){ window.location.href='../../reporter.php'; });
  });
})();
</script>

<style>
/* Minimal modal styling that should play well with hacker.css and alert.css */
.report-modal { position: fixed; top:0; left:0; right:0; bottom:0; background: rgba(0,0,0,0.6); display:flex; align-items:center; justify-content:center; z-index:1000; }
.report-modal-content { background:#0f0f0f; color:#e6e6e6; padding:20px; border-radius:8px; width:90%; max-width:480px; box-shadow:0 6px 18px rgba(0,0,0,0.6); }
.report-modal-title { margin:0 0 8px 0; }
.report-modal-actions { text-align:right; margin-top:12px; }
.btn { padding:8px 12px; border-radius:4px; cursor:pointer; border:none; }
.btn-primary { background:#007bff; color:white; }
.btn-secondary { background:#6c757d; color:white; margin-right:8px; }
</style>

</body>
</html>
