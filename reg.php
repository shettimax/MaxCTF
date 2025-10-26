<?php 
ob_start();
error_reporting(0);
session_start();
include 'confik.php';

if (isset($_POST['signup'])) {
    $ctfid = trim($_POST['ctfid']);
    $ctfemail = $_POST['ctfemail'];
    $ctfname = $_POST['ctfname'];
    $ctfpassword = $_POST['ctfpassword'];
    $retype = $_POST['retype'];
    $ctfskillset = $_POST['ctfskillset'];
    $gender = $_POST['gender'];

    if (empty($ctfemail)) {
        $_SESSION['error'] = "Email required. Please fill it in.";
    } elseif ($ctfpassword !== $retype) {
        $_SESSION['password_match'] = "Oops.. Password Mismatch";
    } elseif (strlen($ctfpassword) > 20) {
        $_SESSION['password_match'] = "Oops.. Password too long (max 20 characters)";
    } else {
        $joined = date('Y-m-d');
        $ctfpassword = sha1($ctfpassword); // hash password using SHA1

        $query = mysqli_query($conn, "INSERT INTO accounts (ctfid, ctfname, ctfscore, joined, ctfskillset, gender, ctfemail, ctfpassword) VALUES ('$ctfid', '$ctfname', '20', '$joined', '$ctfskillset', '$gender', '$ctfemail', '$ctfpassword')");

        if ($query) {
            $_SESSION['success'] = "$ctfid is your username hence Kindly Go&Login";
        } else {
            $_SESSION['error'] = "Not Registered Try Again";
        }
    }
}
ob_end_flush();
?>
<?php include 'header2.php';
?>
<div class="row tall-row">
            <div class="col-lg-12">
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="well">
                    <form method="post" class="form-horizontal">
                        <fieldset>
                            <legend>HINT: gnfx: svaq gur rznvy svryq</legend>
                            <div class="form-group">
                                <label for="inputEmail" class="col-lg-2 control-label">CTFID</label>
                                <div class="col-lg-10">
                                    <input name="ctfid" class="form-control" id="inputEmail" type="text" placeholder="" value=" <?php



function random_num($size) {

  $alpha_key = ''; 

  $keys = range('A', 'Z');



  for ($i = 0; $i < 2; $i++) {

    $alpha_key .= $keys[array_rand($keys)];

  }



  $length = $size - 2;



  $key = '';

  $keys = range(0, 9);



  for ($i = 0; $i < $length; $i++) {

    $key .= $keys[array_rand($keys)];

  }



  return $alpha_key . $key;

}

$ran = random_num(3);
$csc = 'CTF';
$mon = date("md");
$mon1 = date("hs");
echo $csc.''.$ran.''.$mon.''.$mon1;



       

 ?> " readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword" class="col-lg-2 control-label">DATUM</label>
                                <div class="col-lg-10">
                                    <input required name="ctfname" class="form-control" id="inputPassword" placeholder="your cybername" type="text">
                                    <!--<input required name="ctfemail" class="form-control" id="inputPassword" placeholder="your email" type="email">-->
                                    
                                </div>
                            </div>
<div class="form-group">
    <label for="inputPassword" class="col-lg-2 control-label">PASSWORD</label>
    <div class="col-lg-10">
        <input required name="ctfpassword" class="form-control" id="inputPassword" type="password" placeholder="set your password" maxlength="20">
    </div>
</div>

<!-- RETYPE -->
<div class="form-group">
    <label for="inputRetype" class="col-lg-2 control-label">RETYPE</label>
    <div class="col-lg-10">
        <input required name="retype" class="form-control" id="inputRetype" type="password" placeholder="retype password" maxlength="20">
    </div>
</div>


                           <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Skillset</label>
                                <div class="col-lg-10">
                                    <select required name="ctfskillset" class="form-control" id="select">
                                        <option></option>
                                        <?php
                                                 $sql = "SELECT `skillset` FROM `skillsets` ";
                                                    $result = mysqli_query($conn,$sql);
                                                         while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value='" . $row['skillset'] . "'>" . $row['skillset'] . "</option>";}
                                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select" class="col-lg-2 control-label">Gender</label>
                                <div class="col-lg-10">
                                    <select required name="gender" class="form-control" id="select">
                                        <option></option>
                                        <?php
                                                 $sql = "SELECT `gender` FROM `genders` ";
                                                    $result = mysqli_query($conn,$sql);
                                                         while ($row = mysqli_fetch_array($result)) {
                                                    echo "<option value='" . $row['gender'] . "'>" . $row['gender'] . "</option>";}
                                                    ?>
                                    </select>
                                    <div class="checkbox">
                                        <label>
                                            <input required type="checkbox"> i agree & accept rules stated <a href="disclaimer.php">here</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Reset</button>
                                    <button type="submit" name="signup" class="btn btn-primary">Submit</button> Already have account? <button type="button" class="btn btn-default" onclick="window.location.href='login.php'">LOGIN</button>
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
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
if (isset($_SESSION['password_match'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Oops!',
        text: "<?php echo $_SESSION['password_match']; ?>",
        icon: 'warning',
        background: '#0f0f0f',
        color: '#ff0033',
        confirmButtonColor: '#ff0033'
    });
});
</script>
<?php 
unset($_SESSION['password_match']);
} elseif (isset($_SESSION['success'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'SUCCESSFUL!',
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
} elseif (isset($_SESSION['error'])) {
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
} 
?>
            <?php include 'footer.php';
?>