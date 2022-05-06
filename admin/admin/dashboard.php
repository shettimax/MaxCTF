<?php
ob_start();
session_start();
error_reporting(0);
if(strlen($_SESSION['alogin'])==0)
{	
header('location:index.php');
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4 mb-4"><i class="fas fa-bezier-curve" style="margin-right: 5px;"></i>Over-view</h1>
<div class="row">

<div class="col-xl-3 col-md-6">
<div class="card bg-info text-white mb-4">
<div class="card-body">
<i class="fas fa-users"></i>    
<span class="mr-5">Total Users</span>
<?php 
include_once 'config.php';
$queryx =mysqli_query($conn,"SELECT id from accounts");
$rowcount=mysqli_num_rows($queryx);
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $rowcount; ?></span>
</div>
<div class="card-footer d-flex align-items-center justify-content-between">

<div class="small text-white">total 1337s onboard</div>
</div>

</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-success text-white mb-4">
<div class="card-body">
<i class="fas fa-money-check-alt"></i>    
<span class="mr-5"> CTF-Reports</span>
<?php 
include_once 'config.php';
$queryxi =mysqli_query($conn,"SELECT id from reportx where status='pending'");
$rowcount=mysqli_num_rows($queryxi);
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $rowcount; ?></span>
</div>
<div class="card-footer d-flex align-items-center justify-content-between">

<div class="small text-white">unverified/pending flags</div>
</div>

</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-success text-white mb-4">
<div class="card-body">
<i class="fas fa-bezier-curve"></i>    
<span class="mr-5">Captured</span>
<?php 
include_once 'config.php';
$queryxx =mysqli_query($conn,"SELECT id from reportx where status='approved'");
$rowcount=mysqli_num_rows($queryxx);
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $rowcount; ?></span>
</div>
<div class="card-footer d-flex align-items-center justify-content-between">

<div class="small text-white">total verified flags</div>
</div>

</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-info text-white mb-4">
<div class="card-body">
<i class="fa fa-retweet"></i>    
<span class="mr-5">Moderators</span>
<?php 
include_once 'config.php';
$queryxxi =mysqli_query($conn,"SELECT id from modz");
$rowcount=mysqli_num_rows($queryxxi);
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $rowcount; ?></span>
</div>
<div class="card-footer d-flex align-items-center justify-content-between">

<div class="small text-white">moderators veryfing ctf's</div>
</div>

</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-success text-white mb-4">
<div class="card-body">
<i class="fa fa-shopping-cart"></i>    
<span class="mr-5">CTF-Skillsets</span>
<?php 
include_once 'config.php';
$queryzx =mysqli_query($conn,"SELECT id from skillsets");
$rowcount=mysqli_num_rows($queryzx);
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $rowcount; ?></span>
</div>
<div class="card-footer d-flex align-items-center justify-content-between">
<?php
                                       
                                        $get="select skillset from skillsets limit 2";
                                        $run=mysqli_query($conn,$get);
                                        while($row_pro=mysqli_fetch_array($run))
                                        {
                                            $idx=$row_pro['id'];
                                            $pkgx=$row_pro['skillset'];
                                  
                                        ?>
<div class="small text-white"><?php echo $pkgx; ?></div><?php } ?>
</div>

</div>
</div>

<div class="col-xl-3 col-md-6">
<div class="card bg-info text-white mb-4">
<div class="card-body">
<i class="fa fa-retweet"></i>    
<span class="mr-5">Points Out</span>
<?php 
include_once 'config.php';
$query2 = "SELECT sum(ctfscore) as sent_out_amount FROM `accounts` WHERE farko='1'";
	$result = mysqli_query($conn,$query2) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) 
	{
        while($row=mysqli_fetch_array($result))
        {
			$total_sent_amount=$row['sent_out_amount'];
           
		}
	}
?>
<span style="font-weight: bold;font-size: 20px;"><?php echo $total_sent_amount; ?></span>pts
</div>
<div class="card-footer d-flex align-items-center justify-content-between">

<div class="small text-white">total/sum of awarded points</div>
</div>

</div>
</div>


</div>
</div>
</main>
<?php include 'footer.php'; ?>