<?php
ob_start();
session_start();

include 'confik.php';

if(isset($_SESSION['id']))
{
if(strlen($_SESSION['id'])!=0)
	{	
header('location:profile.php');
}
}
    
if (isset($_POST['login']))
{
	$username = $_POST['ctfid'];
    $password = $_POST['ctfpassword'];	
    //$password=md5($password);
    $query = "SELECT * FROM accounts WHERE ctfid='$username' and ctfpassword='$password'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) 
	{
		while($row=mysqli_fetch_array($result))
        {
            $ctfid=$row['ctfid'];
        }
        $_SESSION['id']=$ctfid;
        $queryzi=mysqli_query($conn,"update accounts set farko='1' where ctfid='$ctfid'");
		header('Location:profile.php');
	}
    else{
		$_SESSION['error']="Invalid Details";
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
                            <legend>HINT: pgsvq&pgsrznvy lbh ert jvgu</legend>
                            <div class="form-group">
                                <label for="inputPassword" class="col-lg-2 control-label">DATUM</label>
                                <div class="col-lg-10">
                                    <input required name="ctfid" class="form-control" id="inputPassword" placeholder="your ctfid" type="text">
                                    <input required name="ctfpassword" class="form-control" id="inputPassword" placeholder="your ctfemail" type="password">
                                    
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
