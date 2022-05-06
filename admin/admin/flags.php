<?php
ob_start();
session_start();
error_reporting(0);


include 'config.php';

if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}

?>

<?php 
// if(isset($_GET['action']) && $_GET['action']=='confirm')
// {
//     $id=$_GET['id'];
//     $walletid=$_GET['wallet_id'];
//     $amount=$_GET['amount'];
    
//     $query = "SELECT * FROM account WHERE label='$walletid'";
// 	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
//     $count = mysqli_num_rows($result);
// 	if (mysqli_num_rows($result) > 0) 
// 	{
//         while($row=mysqli_fetch_array($result))
//         {
// 			$balance=$row['balance'];
// 		}
//     }
//     $current_balance=$balance+$amount;

//     $sql="update account set balance='$current_balance' where label='$walletid'";
//     $check_success=mysqli_query($conn,$sql);

//     if($check_success)
//     {
//         mysqli_query($conn,"update topup set status='approved' where id='$id'");
//     $class="success";
//     $message="Status Approved ,Balance Updated";
//     }

// }
if(isset($_POST['submit']))
{
    $walletid=$_POST['walletid'];
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Flags / Bugs</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">approve/verify flags here view pix to be sure</li>
                        </ol>
                        <form method="post">
    <div class="form-group">
        <label>Search CTFID</label>
        <input type="text" class="form-control" name="walletid">
        
        <input style="margin-top: 10px;" type="submit" name="submit" value="Search" class="btn btn-primary">
    </div>
</form>

                        <div class="card mb-4">
                            <div class="card-header">
                              
                                
                             
                            </div>
                         
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                
                                                <th>ID</th>
                                                <th>CTF ID</th>
                                                <th>Point</th>
                                                <th>Date/Flag</th>
                                                <th>Prove Image</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                      
                                     


                                        <tbody>

                                        <?php
                                       
                                        $get="select * from reportx where status='pending'";
                                        $run=mysqli_query($conn,$get);
                                        while($row_pro=mysqli_fetch_array($run))
                                        {
                                            $id=$row_pro['id'];
                                            $wallet_id=$row_pro['walletid'];
                                            $amount=$row_pro['amount'];
                                            $date=$row_pro['date'];
                                            $proofimage=$row_pro['proofimage'];
                                            $status=$row_pro['status'];
                                            $bug=$row_pro['bug'];
                                            $severity=$row_pro['severity'];
                                           
                                            
                                            
                                        ?>

                                            <tr>
                                                <td><?php echo htmlentities($id);?></td>
                                                <td><?php echo htmlentities($wallet_id);?></td>
                                                <td><?php echo htmlentities($amount);?></td>
                                                <td><?php echo date("d-m-Y/h:m:s", strtotime($date)); ?><br><?php echo htmlentities($bug);?> <?php echo htmlentities($severity);?></td>
                                                <td><a href="../../<?php echo $proofimage; ?>" target="_blank"><img src="../../<?php echo $proofimage; ?>" width="150px" height="80px"></td></a>
                                               
                                               
                                                <td>
                                                    <?php if($status=='pending')
                                                    { ?>
                                               <a id="status_change" class="btn btn-primary" href="#"><i class="fas fa-check-circle" style="margin-right: 5px;"></i>Approve</a>
                                                    <?php } 
                                                    else
                                                    {
                                        
                                                    ?>
                                                    <span class="badge badge-success">Approved</span>
                                                    <?php } ?>
                                    
                                              </td>
                                            
                                                
                                               
                                            </tr>
                                          
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
             <?php include 'footer.php'; ?>