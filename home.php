<?php include 'header.php';
?>

        
        <!-- Aboutus -->
        <div class="row tall-row">
            <div class="col-lg-12">
                <h2>-</h2>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="alert alert-dismissible alert-warning">
                    <button type="button" class="close">*</button>
                    <h4 style="color:#00ff99;"><u>About us</u></h4>
                    <p><?php echo $about; ?><br><a href="https://www.google.com/search?q=what+is+ctf+in+cyber+security&oq=what+is+ctf+in+c&aqs=chrome.0.0l2j69i57j0l3j69i60l2.5438j1j7&sourceid=chrome&ie=UTF-8" class="alert-link">read-more</a>.</p>
                </div>

<!-- Rules -->
        <b><div class="row tall-row">
            <div class="col-lg-12">
                <h1 style="color:#00ff99;">! Rules</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="well">
                    Don't DDOS!
                </div>
                <div class="well">
                    Don't share flags!
                </div>
            </div>
            <div class="col-md-4">
                <div class="well well-sm">
                    Don't help anyone!
                </div>
                <div class="well well-sm">
                    Submit whatever flag you got on the go!
                </div>
                <div class="well well-sm">
                    Don't be hard on main platform!
                </div>
            </div>
            <div class="col-md-4">
                <div class="well well-lg">
                    Focus on your CTF targets!
                </div>
                <div class="well well-lg">
                    #Good Luck!
                </div>
            </div>
        </div></b>

        <!-- List Groups for infotab -->
        <div class="row tall-row">
            <div class="col-lg-12">
                <h1 style="color:#00ff99;">Info-Tab</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <ul class="list-group">
                    <?php 
include_once 'config.php';
$queryx =mysqli_query($conn,"SELECT id from accounts");
$rowcount=mysqli_num_rows($queryx);
?>
                    <li class="list-group-item">
                        <span class="badge"><?php echo $rowcount; ?></span>
                        users onboard
                    </li>
                    <li class="list-group-item">
                        <?php 
include_once 'config.php';
$queryx =mysqli_query($conn,"SELECT id from accounts where ctfskillset='noob'");
$rowcount=mysqli_num_rows($queryx);
?>
                        <span class="badge"><?php echo $rowcount; ?></span>
                        n00bs
                    </li>
                    <li class="list-group-item">
                        <?php 
include_once 'config.php';
$queryx =mysqli_query($conn,"SELECT id from accounts where ctfskillset='1337'");
$rowcount=mysqli_num_rows($queryx);
?>
                        <span class="badge"><?php echo $rowcount; ?></span>
                        1337s
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <ul class="list-group">
                    <li class="list-group-item">
                        <span class="badge">WYFIWWS</span>
                        Bugs
                    </li>
                    <li class="list-group-item">
                        <span class="badge">40+</span>
                        Targets
                    </li>
                    <li class="list-group-item">
                        <?php 
include_once 'config.php';
$queryxx =mysqli_query($conn,"SELECT id from bugs");
$rowcount=mysqli_num_rows($queryxx);
?>
                        <span class="badge"><?php echo $rowcount; ?></span>
                        <strike>Known Bugs</strike>
                    </li>
                    <li class="list-group-item">
                    	<?php 
include_once 'config.php';
$queryxxi =mysqli_query($conn,"SELECT id from reportx");
$rowcount=mysqli_num_rows($queryxxi);
?>
                        <span class="badge"><?php echo $rowcount; ?></span>
                        Flags-found
                    </li>
                </ul>
            </div>
            <div class="col-lg-4">
                <div class="list-group">
                    <a xhref="index.php#" class="list-group-item">
                        <h4 class="list-group-item-heading"><u>CTF Preparedness</u></h4>
                        <p class="list-group-item-text">If you’ve never experienced a CTF event before, don’t get frustrated or give up, because the key to any type of hacking is patience.</p>
                    </a>
                    <a xhref="index.php#" class="list-group-item">
                        <h4 class="list-group-item-heading"><u>What is WWSIWYF?</u></h4>
                        <p class="list-group-item-text">what you found is what we see. ^_^</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tables for top5 -->
        <div class="row tall-row">
            <div class="col-lg-12">
                <h1 style="color:#00ff99;">T<img src="http://shettima.xtgem.com/images/ion.png" width="37" height="37"/>p5 Solvers</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr style="color:#964B00;">
                            <th>#</th>
                            <th>CTFID</th>
                            <th>CTFNAME</th>
                            <th>JOINED</th>
                            <th>CTFSCORE</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                       
                                        $getr="SELECT * FROM `accounts` WHERE farko='1' ORDER BY ctfscore DESC LIMIT 5";
                                        $run=mysqli_query($conn,$getr);
                                        while($row_pro=mysqli_fetch_array($run))
                                        {
                                            $ctfid=$row_pro['ctfid'];
                                            $ctfname=$row_pro['ctfname'];
                                            $joined=$row_pro['joined'];
                                            $ctfscore=$row_pro['ctfscore'];
                                           
                                            
                                            
                                        ?>
                        <tr>
                            <td>></td>
                            <td><a href="whoiswho.php?ctfid=<?php echo urlencode($ctfid); ?>" title="click to see userinfo"><?php echo htmlentities($ctfid); ?></a></td>
                            <td><?php echo htmlentities($ctfname);?></td>
                            <td><?php echo htmlentities($joined);?></td>
                            <td><?php echo htmlentities($ctfscore);?></td>
                        </tr>
                       <!-- <tr>
                            <td>2</td>
                            <td>BLAH</td>
                            <td>Lion</td>
                            <td>Casterly Rock</td>
                        </tr>
                        <tr class="info">
                            <td>3</td>
                            <td>Baratheon</td>
                            <td>Stag</td>
                            <td>Storm's End</td>
                        </tr>
                        <tr class="success">
                            <td>4</td>
                            <td>Targaryen</td>
                            <td>3-headed Dragon</td>
                            <td>Slaver's Bay</td>
                        </tr>
                        <tr class="active">
                            <td>5</td>
                            <td>Bolton</td>
                            <td>Red flayed man</td>
                            <td>Dreadfort / Winterfell</td>
                        </tr> -->
                         <?php } ?>
                    </tbody>
                </table> 
            </div>
        </div>

        


        <!-- Dialogged disclaimer -->
        <div class="row tall-row">
            <div class="col-lg-12">
                <h1 style="color:#00ff99;">Disclaimer</h1>
                <hr>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="modal">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h4 class="modal-title">[!] <u>HEADS UP</u> [!]</h4>
                            </div>
                            <div class="modal-body">
                                <p><?php echo $disclaimer; ?></p>
                            </div>
                            <div class="modal-footer">
                                by: <button type="button" class="btn btn-default" data-dismiss="modal">YWRtaW4=</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
<?php include 'footer.php';
?>