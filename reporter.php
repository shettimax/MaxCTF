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

$bugg=$_POST['bugx'];
        $amount=$_POST['amount'];
        $severityy=$_POST['severityx'];
        $date=date('Y-m-d h:m:i');
if(isset($_POST["go"])) {
    $target_dir = "admin/proofimages/";
$target_file = $target_dir . basename($_FILES["proofimage"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["go"])) {
  $check = getimagesize($_FILES["proofimage"]["tmp_name"]);
  if($check !== false) {
    echo "Your";
    $uploadOk = 1;
    $query=mysqli_query($conn,"insert into reportx(walletid,amount,proofimage,date,status,bug,severity) values('$ctfid','$amount','$target_file','$date','pending','$bugg','$severityy')");
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["proofimage"]["size"] > 500000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["proofimage"]["tmp_name"], $target_file)) {
    echo " POC has been uploaded.";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

        if($check !== false)
        {
            $_SESSION['success']="Admin Will Review!";
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
                            <legend>HINT: XRRC UNPXVAT UNPXVAT NEBHAQ</legend>
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
                                        <input name="amount" value="20" type="hidden">
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
swal("Submitted", "<?php echo $_SESSION['success'];?>!", "success");
    </script>
    <?php 
    unset($_SESSION['success']);
    } 
    
    
    ?>
    <?php include 'footer.php';
?>
