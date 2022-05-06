<?php
include 'config.php';
if(isset($_POST['action']) && $_POST['action']=='confirm')
{
    $id=$_POST['id'];
    $walletid=$_POST['walletid'];
    $amount=$_POST['amount'];
    
    $query = "SELECT * FROM accounts WHERE ctfid='$walletid'";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) 
	{
        while($row=mysqli_fetch_array($result))
        {
			$balance=$row['ctfscore'];
		}
    }
    $current_balance=$balance+$amount;

    $sql="update accounts set ctfscore='$current_balance' where ctfid='$walletid'";
    $check_success=mysqli_query($conn,$sql);

    if($check_success)
    {
        mysqli_query($conn,"update reportx set status='approved' where id='$id'");
    }

}
?>