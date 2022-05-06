<?php
//shettimax
ob_start();
session_start();
error_reporting(0);


include 'config.php';

if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}

?>
<?php include 'header.php'; ?>
            <div id="layoutSidenav_content">
                <main>
                    <div class="container-fluid">
                        <h1 class="mt-4">Users</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                            <li class="breadcrumb-item active">users</li>
                        </ol>
                        <form method="post">
    <div class="form-group">
        <label>Search By CTFID</label>
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
                                                <th>CTFID</th>
                                                <th>Cybername</th>
                                                <th>Points</th>
                                                <th>Joined</th>
                                                <th>Skillset</th>
                                            </tr>
                                        </thead>
                                      
                                     


                                        <tbody>

                                        <?php
                                       
                                        $get="select * from accounts";
                                        $run=mysqli_query($conn,$get);
                                        while($row_pro=mysqli_fetch_array($run))
                                        {
                                            $id=$row_pro['id'];
                                            $label=$row_pro['ctfid'];
                                            $username=$row_pro['ctfname'];
                                            $Fullname=$row_pro['gender'] . '    '. $row_pro['ctfskillset'] ;
                                            $farko=$row_pro['farko'];
                                            $date=$row_pro['joined'];
                                            $score=$row_pro['ctfscore'];
                                           
                                            
                                            
                                        ?>

                                            <tr>
                                                <td><?php echo htmlentities($id);?></td>
                                                <td><?php echo htmlentities($label);?></td>
                                                <td><?php echo htmlentities($username);?></td>
                                                <td><?php echo htmlentities($score);?></td>
                                                <td><?php echo htmlentities($date);?></td>
                                               
                                                <td>
                                                    <?php if($farko=='1')
                                                    { ?>
                                               <a id="status_change" class="btn btn-primary"><i class="fas fa-check-circle" style="margin-right: 5px;"></i><?php echo $Fullname; ?></a>
                                                    <?php } 
                                                    else
                                                    {
                                        
                                                    ?>
                                                    <span class="badge badge-success">CANTBYPASSREG</span>
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
             <?php include 'footer2.php'; ?>
