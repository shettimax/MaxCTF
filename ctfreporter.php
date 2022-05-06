<?php
ob_start();
session_start();
include 'confik.php';
if(strlen($_SESSION['id'])==0)
    {   
header('location:login.php');
}
$ctfid=$_SESSION['id'];
$query = "SELECT * FROM accounts WHERE ctfid='$ctfid'";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) 
    {
        while($row=mysqli_fetch_array($result))
        {
            $ctfscore=$row['ctfscore'];
            $ctfname=$row['ctfname'];
           
        }
    }

    $query = "select * from site order by rand() limit 1";
    $result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
    if (mysqli_num_rows($result) > 0) 
    {
        while($row=mysqli_fetch_array($result))
        {
            $name=$row['name'];
            $bankname=$row['bnkname'];
            $banknumber=$row['bnkno'];
           
        }
    }


    if(isset($_POST['go']))
    {
        $file = $_FILES['proofimage']['name'];
        $file_loc = $_FILES['proofimage']['tmp_name'];
        $folder="admin/proofimages/";
        $new_file_name = strtolower($file);
        $final_file=str_replace(' ','-',$new_file_name);
    
        if(move_uploaded_file($file_loc,$folder.$final_file))
            {
                $image=$final_file;
            }

        $amount=$_POST['bugx'];
        $amountt=$_POST['severityx'];
        $date=date('Y-m-d h:m:i');
        $query=mysqli_query($conn,"insert into reportz(ctftid,proofimage,date,status,bug,severity) values('$ctfid','$image','$date','pending','$amount','$amountt')");
        if($query)
        {
            $url="profile.php";
            $_SESSION['success']="Request submitted Admin will Review!";
            echo "<script>
            window.location.href='$url'
            </script>";
        }
        else
        {
            $_SESSION['error']="Request Not submitted";
        }
    }
    ob_end_flush();
?>
<?php include 'header2.php';
?>
<div class="row tall-row">
            <div class="col-lg-12">
                <h1>lbh'yy trg gjragl cbvagf</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="well">
                    <form method="post" enctype="multipart/form-data" class="form-horizontal">
                        <fieldset>
                            <legend>HINT: PGSVQ&PGSRZNVY JVYY OR LBHE YBTVA VASB</legend>
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
                                            <input required type="checkbox"> i agree & accept rules stated <a href="disclaimer.php">here</a>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="reset" class="btn btn-default">Reset</button>
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
swal("", "<?php echo $_SESSION['success'];?>!", "success");
    </script>
    <?php 
    unset($_SESSION['success']);
    } 
    
    
    ?>
    <?php include 'footer.php';
?>
