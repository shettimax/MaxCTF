<?php
ob_start();
session_start();
include 'confik.php';

if (isset($_SESSION['id']) && strlen($_SESSION['id']) != 0) {
    header('location:profile.php');
}

if (isset($_POST['login'])) {
    // Sanitize inputs
    $username = mysqli_real_escape_string($conn, trim($_POST['ctfid']));
    $raw_password = trim($_POST['ctfpassword']);
    $password = sha1($raw_password); // hash after trimming

    $query = "SELECT * FROM accounts WHERE ctfid='$username' AND ctfpassword='$password'";
    $result = mysqli_query($conn, $query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);

    if ($count > 0) {
        while ($row = mysqli_fetch_array($result)) {
            $ctfid = $row['ctfid'];
            $ctfname = $row['ctfname'];
        }

        $_SESSION['id'] = $ctfid;
        $_SESSION['ctfid'] = $ctfid;
        $_SESSION['ctfname'] = $ctfname;

        // Only set 'farko' if it's currently NULL wato empty
mysqli_query($conn, "UPDATE accounts SET farko='1' WHERE ctfid='$ctfid' AND farko IS NULL");

// Always reward login with 5 points
mysqli_query($conn, "UPDATE accounts SET ctfscore = ctfscore + 5 WHERE ctfid='$ctfid'");
        header('Location:profile.php');
    } else {
        echo "<link rel='stylesheet' href='css/alert.css'>
        <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Access Denied',
                text: 'Invalid CTF ID or Password',
                icon: 'error',
                background: '#0f0f0f',
                color: '#ff0033',
                confirmButtonColor: '#ff0033',
                confirmButtonText: 'Try Again'
            });
        });
        </script>";
    }
}

ob_end_flush();
?>

<?php include 'header2.php';
?>
<div class="row tall-row">
            <div class="col-lg-12">
                <h1>" sbegvf sbeghan nqvhing "</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="well">
                    <form method="post" class="form-horizontal">
                        <fieldset>
                            <legend>HINT: pgsvq&pgscnffjbeq lbh ert jvgu</legend>
                            <div class="form-group">
                                <label for="inputPassword" class="col-lg-2 control-label">DATUM</label>
                                <div class="col-lg-10">
                                    <input required name="ctfid" class="form-control" id="inputPassword" placeholder="your ctfid" type="text">
                                    <input required name="ctfpassword" class="form-control" id="inputPassword" placeholder="your ctfpassword">
                                    
                                </div>
                            </div>
                                    <div class="checkbox">
                                        <label>
                                            <input required type="checkbox"> i agree & accept rules stated <a href="disclaimer.php">here</a>
                                        </label>
                                    </div>
                                
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <button type="submit" name="login" class="btn btn-primary">Submit</button>
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
swal("0Oops", "<?php echo $_SESSION['error'];?>!", "error");
    </script>
    <?php 
    unset($_SESSION['error']);
    } 
    ?>
            <?php include 'footer.php';
?>
