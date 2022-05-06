<?php 
ob_start();
error_reporting(0);
include 'confik.php';
if(isset($_POST['signup']))
{
    
$ctfid=$_POST['ctfid'];
$ctfid=trim($ctfid);

$ctfemail=$_POST['ctfemail'];
$ctfname=$_POST['ctfname'];
$ctfpassword=$_POST['ctfemail'];
$ctfskillset=$_POST['ctfskillset'];
$gender=$_POST['gender'];
if($ctfpassword!=$ctfemail)
{
    $_SESSION['password_match']="Oops.. Password Mismatch";
}
else
{
$joined=date('Y-m-d');


$query=mysqli_query($conn,"insert into accounts(ctfid,ctfname,ctfscore,joined,ctfskillset,gender,ctfemail,ctfpassword) values('$ctfid','$ctfname','20','$joined','$ctfskillset','$gender','$ctfemail','$ctfpassword','')");
if($query)
{
    $_SESSION['success']="$ctfskillset Kindly Go&Login";
}
else
{
    $_SESSION['error']="Not Registered Try Again";
}
}
}
ob_end_flush();
?>
<?php include 'header2.php';
?>
<div class="row tall-row">
            <div class="col-lg-12">
                <h1>gnfx: svaq gur rznvy svryq</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="well">
                    <form method="post" class="form-horizontal">
                        <fieldset>
                            <legend>HINT: PGSVQ&PGSRZNVY JVYY OR LBHE YBTVA VASB</legend>
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
                                    <!--<input required name="ctfemail" class="form-control" id="inputPassword" placeholder="your email" type="text">-->
                                    
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
                                    <button type="submit" name="signup" class="btn btn-primary">Submit</button>
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
    if($_SESSION['password_match'])
    {
    ?>
    <script>
swal("", "<?php echo $_SESSION['password_match'];?>!", "warning");
    </script>
    <?php 
    unset($_SESSION['password_match']);
    } 
    else if($_SESSION['success'])
    {
    ?>
    <script>
swal("Success", "<?php echo $_SESSION['success'];?>!", "success");
    </script>
    <?php 
    unset($_SESSION['success']);
    } 
    else if($_SESSION['error'])
    {
    ?>
    <script>
swal("Taken", "<?php echo $_SESSION['error'];?>!", "error");
    </script>
    <?php 
    unset($_SESSION['error']);
    } 
    ?>
            <?php include 'footer.php';
?>