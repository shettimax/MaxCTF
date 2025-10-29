<?php
session_start();
include("confik.php");

ini_set('display_errors', 0);
error_reporting(E_ALL);

if (!isset($_SESSION['id']) || strlen($_SESSION['id']) == 0) {
    header("location:login.php");
    exit();
}

$ctfid = $_SESSION['ctfid'];
$ctfname = $_SESSION['ctfname'];

$site = mysqli_query($conn, "SELECT * FROM site ORDER BY RAND() LIMIT 1");
$siterow = mysqli_fetch_array($site);
$name = $siterow['sitename'];
$bankname = $siterow['header'];
$banknumber = $siterow['header2'];

if (isset($_POST['go'])) {
    $bug = $_POST['bugx'];
    $severity = $_POST['severityx'];
    $amount = $_POST['amount'];
    $date = date("Y-m-d H:i:s");

    $target_dir = "admin/admin/proofimages/";
    $target_file = $target_dir . basename($_FILES["proofimage"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["proofimage"]["size"] > 500000) {
        $uploadOk = 0;
        $_SESSION['error'] = "File too large. Max allowed size is 500KB.";
    }

    if (!in_array($imageFileType, ["jpg", "jpeg", "png", "gif"])) {
        $uploadOk = 0;
        $_SESSION['error'] = "Invalid file format.";
    }

    if ($uploadOk == 1) {
        if (move_uploaded_file($_FILES["proofimage"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO reportx (walletid, amount, proofimage, date, status, bug, severity) 
                    VALUES ('$ctfid', '$amount', '$target_file', '$date', 'pending', '$bug', '$severity')";
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

<!-- combo SweetAlert2 + alert.css -->
<link rel="stylesheet" href="css/alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if (isset($_SESSION['error'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Error',
        text: "<?php echo $_SESSION['error']; ?>",
        icon: 'error',
        background: '#0f0f0f',
        color: '#ff0033',
        confirmButtonColor: '#ff0033'
    });
});
</script>
<?php 
unset($_SESSION['error']);
} else if (isset($_SESSION['success'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Success',
        text: "<?php echo $_SESSION['success']; ?>",
        icon: 'success',
        background: '#0f0f0f',
        color: '#00ff99',
        confirmButtonColor: '#00ff99'
    });
});
</script>
<?php 
unset($_SESSION['success']);
} 
?>

<?php include 'header2.php'; ?>
<!-- Your form and page content continues below -->
<div class="row tall-row">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="well">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        <fieldset>
                            <legend class="text-green">GUVF GBB VF N PUNYYRATR</legend>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">CTFID</label>
                                <div class="col-lg-10">
                                    <input name="ctfid" class="form-control" id="inputEmail" type="text" placeholder="" value="<?php echo $ctfid; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-lg-2 control-label">NOM</label>
                                <div class="col-lg-10">
                                    <input required name="ctfname" class="form-control" id="inputPassword" placeholder="" value="<?php echo $ctfname; ?>" type="text" readonly>
                                    <!--<input name="ctfemail" class="form-control" id="inputPassword" placeholder="your email" type="text">-->
                                    
                                </div>
                            </div>
                           <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">CTF-Poc's</label>
                                <div class="col-lg-10">
                                    <select required name="bugx" class="form-control" id="select">
                                        <option>see bugtype</option>
                                        <?php
                                                 $sql = "SELECT `bug` FROM `bugs` ";
                                                    $result = mysqli_query($conn,$sql);
                                                         while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value='" . $row['bug'] . "'>" . $row['bug'] . "</option>";}
                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">CTF-Poc's</label>
                                <div class="col-lg-10">
                            <input required type="file" name="proofimage" accept="image/x-png,image/gif,image/jpeg" class="form-control" placeholder="">
                        </div>
                    </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">.></label>
                                <div class="col-lg-10">
                                    <select required name="severityx" class="form-control" id="select">
                                        <option>choose severity</option>
                                        <?php
                                                 $sql = "SELECT `severity` FROM `severities` ";
                                                    $result = mysqli_query($conn,$sql);
                                                         while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value='" . $row['severity'] . "'>" . $row['severity'] . "</option>";}
                                                    ?>
                                    </select>
                                    <div class="checkbox">
                                        <label>
                                            <input required type="checkbox"> i agree & accept rules stated
                                        </label>
                                        <input name="amount" value="20" type="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <button type="button" class="btn btn-default" onclick="window.location.href='profile.php'">Go Back</button>
                                    <button type="submit" name="go" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
                <!--Page loader DOM Elements. Requared all pages-->
    <div class="sweet-loader">
        <div class="box">
            <div class="circle1"></div>
            <div class="circle2"></div>
            <div class="circle3"></div>
        </div>
    </div>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <?php 
    if($_SESSION['error'])
    {
    ?>
    <script>
swal("000PS", "<?php echo $_SESSION['error'];?>!", "error");
    </script>
    <?php 
    unset($_SESSION['error']);
    } 
    else if($_SESSION['success'])
    {
    ?>
    <script>
swal("Submitted", "<?php echo $_SESSION['success'];?>!", "success");
    </script>
    <?php 
    unset($_SESSION['success']);
    } 
    
    
    ?>
    <?php include 'footer.php';
?>
