<?php
ob_start();
session_start();
include 'confik.php';
if(strlen($_SESSION['id'])==1)
	{	
header('location:index.php');
}
$ctfid=$_SESSION['id'];
$query = "SELECT * FROM accounts";
	$result = mysqli_query($conn,$query) or die(mysqli_error($conn));
    $count = mysqli_num_rows($result);
	if (mysqli_num_rows($result) > 0) 
	{
        while($row=mysqli_fetch_array($result))
        {
			$ctfid=$row['ctfid']; //main balance
			$ctfname=$row['ctfname']; //fetch colmn username  so2 echo l8r
			$ctfscore=$row['ctfscore']; //join 1st n last name of user
			$joined=$row['joined']; // registration date
			$ctfskillset=$row['ctfskillset'];
			$gender=$row['gender']; //user investment/package
			$ctfemail=$row['ctfemail']; //referal earnings
           
		}
	}
	ob_end_flush();
?>
<?php include 'header2.php';?>
<div class="col-md-4">
                <h3>Tabs</h3>
                <ul class="nav nav-tabs">
                    <li class="active"><a aria-expanded="true" href="index.html#home" data-toggle="tab">Home</a></li>
                    <li class=""><a aria-expanded="false" href="index.html#profile" data-toggle="tab">Profile</a></li>
                    <li class="dropdown">
                        <a aria-expanded="false" class="dropdown-toggle" data-toggle="dropdown" href="index.html#">Miscell.. <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="index.html#dropdown1" data-toggle="tab">Leadership Board</a></li>
                            <li class="divider"></li>
                            <li><a href="index.html#dropdown2" data-toggle="tab">Submit Report</a></li>
                            <li class="divider"></li>
                            <li><a href="logout.php" data-toggle="tab"><b>./exit</b></a></li>
                        </ul>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div class="tab-pane fade active in" id="home">
                        <p>welcome <?php echo $ctfskillset; ?>, <?php echo $ctfname; ?>.</p>
                    </div>
                    <div class="tab-pane fade" id="profile">
                        <p><img src="http://shettima.xtgem.com/images/ion.png" width="50" height="50" alt="hehe" caption="user"/> <br>>> <?php echo $ctfname; ?> (<?php echo $gender; ?>)
<br>>> <?php echo $ctfid; ?> (<?php echo $ctfskillset; ?>) <br>joined: <u><?php echo $joined; ?></u> <br>>> <u><?php echo $ctfemail; ?></u></p>
                    </div>
                    <div class="tab-pane fade" id="dropdown1">
                        <p>yourscore: <?php echo $ctfscore; ?>points <br>click <a href="leadershipboard.php">here</a> to see fullboard</p>
                    </div>
                    <div class="tab-pane fade" id="dropdown2">
                        <p>need more points? capture some flags & submit <a href="profile.php">here</a> <br>^_^ or crack cmVwb3J0ZXI= (.php) <br>points shall be rewarded once moderators verify it.</p>
                    </div>
                </div>
            </div>
        </div>
&nbsp; <?php include 'footer.php';?>
