<?php
include("session.php");
include("confik.php");

ini_set('display_errors', 0);
error_reporting(E_ALL);

// Session check
if (!isset($_SESSION['id']) || empty($_SESSION['ctfid']) || empty($_SESSION['ctfname'])) {
    header("Location: login.php");
    exit();
}

$ctfid = $_SESSION['ctfid'];
$ctfname = $_SESSION['ctfname'];

// CSRF token
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
}

// Site info
$site = mysqli_query($conn, "SELECT * FROM site ORDER BY RAND() LIMIT 1");
$siterow = mysqli_fetch_array($site);
$name = isset($siterow['sitename']) ? $siterow['sitename'] : "MaxCTF";
$bankname = isset($siterow['header']) ? $siterow['header'] : "CTF Bank";
$banknumber = isset($siterow['header2']) ? $siterow['header2'] : "000000";

// Handle form submission
if (isset($_POST['go'])) {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['error'] = "Invalid CSRF token.";
        header("Location: ctfreporter.php");
        exit();
    }

    $bug = $_POST['bugx'];
    $severity = $_POST['severityx'];
    $rawNotes = $_POST['notes'];
    $notes = htmlspecialchars(strip_tags(substr($rawNotes, 0, 120)), ENT_QUOTES, 'UTF-8');
    $date = date("Y-m-d H:i:s");

    $target_dir = "admin/proofimages/";
    if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

    $timestamp = time();
    $extension = strtolower(pathinfo($_FILES["proofimage"]["name"], PATHINFO_EXTENSION));
    $filename = $ctfid . "_" . $timestamp . "." . $extension;
    $target_file = $target_dir . $filename;
    $uploadOk = 1;

    // File checks
    if ($_FILES["proofimage"]["size"] > 500000) {
        $uploadOk = 0;
        $_SESSION['error'] = "File too large. Max allowed size is 500KB.";
    }

    if (!in_array($extension, array("jpg", "jpeg", "png", "gif"))) {
        $uploadOk = 0;
        $_SESSION['error'] = "Invalid file extension.";
    }

    if (!is_uploaded_file($_FILES["proofimage"]["tmp_name"])) {
        $uploadOk = 0;
        $_SESSION['error'] = "No valid file uploaded.";
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mimeType = finfo_file($finfo, $_FILES["proofimage"]["tmp_name"]);
    finfo_close($finfo);
    $allowedMimeTypes = array("image/jpeg", "image/png", "image/gif");
    if (!in_array($mimeType, $allowedMimeTypes)) {
        $uploadOk = 0;
        $_SESSION['error'] = "Invalid MIME type: " . $mimeType;
    }

    // Upload and insert
    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["proofimage"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO reportx (walletid, amount, proofimage, date, status, bug, severity, notes) 
                    VALUES ('$ctfid', '13', '$target_file', '$date', 'pending', '$bug', '$severity', '$notes')";
            if (mysqli_query($conn, $sql)) {
                $_SESSION['success'] = "Submitted! Admin will review.";
            } else {
                $_SESSION['error'] = "Insert failed: " . mysqli_error($conn);
            }
        } else {
            $_SESSION['error'] = "File upload failed.";
        }
    }
}
?>

<?php include 'header2.php'; ?>

<div class="row tall-row"><div class="col-lg-12"><hr></div></div>
<div class="row">
  <div class="col-lg-6">
    <div class="well">
      <form method="post" enctype="multipart/form-data" class="form-horizontal">
        <fieldset>
          <legend class="text-green">Submit Your Finding</legend>

          <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

          <div class="form-group">
            <label class="col-lg-2 control-label">CTFID</label>
            <div class="col-lg-10">
              <input name="ctfid" class="form-control" type="text" value="<?php echo $ctfid; ?>" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Name</label>
            <div class="col-lg-10">
              <input name="ctfname" class="form-control" value="<?php echo $ctfname; ?>" type="text" readonly>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Bug Type</label>
            <div class="col-lg-10">
              <select required name="bugx" class="form-control">
                <option disabled selected>Choose bug type</option>
                <?php
                  $selectedBug = isset($_GET['bugx']) ? $_GET['bugx'] : '';
                  $result = mysqli_query($conn, "SELECT `bug` FROM `bugs`");
                  while ($row = mysqli_fetch_array($result)) {
                    $selected = ($row['bug'] === $selectedBug) ? 'selected' : '';
                    echo "<option value='" . $row['bug'] . "' $selected>" . $row['bug'] . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Proof</label>
            <div class="col-lg-10">
              <input required type="file" name="proofimage" accept="image/jpeg,image/png,image/gif" class="form-control">
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Severity</label>
            <div class="col-lg-10">
              <select required name="severityx" class="form-control">
                <option disabled selected>Choose severity</option>
                <?php
                  $selectedSeverity = isset($_GET['severityx']) ? $_GET['severityx'] : '';
                  $result = mysqli_query($conn, "SELECT `severity` FROM `severities`");
                  while ($row = mysqli_fetch_array($result)) {
                    $selected = ($row['severity'] === $selectedSeverity) ? 'selected' : '';
                    echo "<option value='" . $row['severity'] . "' $selected>" . $row['severity'] . "</option>";
                  }
                ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-lg-2 control-label">Notes</label>
            <div class="col-lg-10">
              <textarea name="notes" id="notes" class="form-control" rows="3" maxlength="120" placeholder="Briefly describe what you found (max 120 chars)"></textarea>
              <small><span id="charCount">0</span>/120 characters</small>
            </div>
          </div>

          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <div class="checkbox">
                <label><input required type="checkbox"> I agree & accept rules stated <a href="disclaimer.php">here</a></label>
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
              <button type="reset" class="btn btn-default">Reset</button>
              <button type="button" class="btn btn-default" onclick="window.location.href='profile.php'">Go Back</button>
              <button type="submit" name="go" id="submitBtn" class="btn btn-primary" disabled>Submit</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script src="js/reporter.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if (isset($_SESSION['error'])) {
  echo "<script>Swal.fire({title:'Error',text:'" . $_SESSION['error'] . "',icon:'error'});</script>";
  unset($_SESSION['error']);
} else if (isset($_SESSION['success'])) {
  echo "<script>Swal.fire({title:'Success',text:'" . $_SESSION['success'] . "',icon:'success'});</script>";
  unset($_SESSION['success']);
}
?>

<?php include 'footer.php'; ?>