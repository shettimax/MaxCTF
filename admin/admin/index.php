<?php
ob_start();
session_start();

include 'config.php';

if(isset($_SESSION['alogin']))
{
if(strlen($_SESSION['alogin'])!=0)
	{	
header('location:dashboard.php');
}
}
    
if (isset($_POST['login']))
{
	$username = $_POST['name'];
    $password = $_POST['password'];	
    //$password=md5($password);
    $query = "SELECT * FROM admin WHERE username='$username' and password='$password'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
	$count = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) 
	{
        $_SESSION['alogin']=$username;
		header('Location:dashboard.php');
	}
    else{
        header('Location:index.php');
    }
}

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>💀</title>
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">CTFBACKBOX💀</h3></div>
                                    <div class="card-body">
                                        <form action="index.php" method="post">
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">user</label>
                                                <input required name="name" class="form-control py-4" id="inputEmailAddress" type="text" placeholder="username" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">password</label>
                                                <input required name="password" class="form-control py-4" id="inputPassword" type="password" placeholder="password" />
                                            </div>
                                          
                                            <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <button class="btn btn-primary" name="login" type="submit">Login</button>
                                             
                                        </div>
                                        </form>
                                    </div>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
          
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
