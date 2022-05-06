<?php
ob_start();
session_start();
include 'confik.php';
if(strlen($_SESSION['id'])==0)
    {   
header('location:disclaimer.php');
}
    ob_end_flush();
?>
<?php include 'header2.php';
?>
almost there buddy!<br>
you wanna lead the scoreboard huh?<br>
crack this: cmVwb3J0ZXI=
----------------------------------<br>
hint: load whatyougotfromcrackingit .php to submit a report/captured flag<br>
----------hint2 0x64617368626f617264 .php holds signal you need 
~goodluck!
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	
	<?php 
	if($_SESSION['error'])
	{
	?>
	<script>
swal("", "<?php echo $_SESSION['error'];?>!", "error");
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