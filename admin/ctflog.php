<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0 || $_SESSION['role'] != 'admin'){
    header('location:index.php');
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-history"></i> Flag History</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Approved & Rejected Flags</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Flag Log</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered text-green" id="dataTable">
<thead>
<tr>
    <th>ID</th>
    <th>CTFID</th>
    <th>Points</th>
    <th>Bug / Severity</th>
    <th>Status</th>
    <th>Note</th>
</tr>
</thead>
<tbody>
<?php
$get = mysqli_query($conn,"SELECT * FROM reportx WHERE status IN ('approved','rejected')");
while($row = mysqli_fetch_array($get)){
?>
<tr>
    <td><?php echo htmlentities($row['id']); ?></td>
    <td><?php echo htmlentities($row['walletid']); ?></td>
    <td><?php echo htmlentities($row['amount']); ?></td>
    <td><?php echo htmlentities($row['bug'].' '.$row['severity']); ?></td>
    <td>
        <?php if($row['status']=='approved'){ ?>
            <span class="badge badge-success">Verified</span>
        <?php } elseif($row['status']=='rejected'){ ?>
            <span class="badge badge-danger">Rejected</span>
        <?php } ?>
    </td>
    <td>
        <?php if(strlen($row['notes']) > 40){ ?>
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#noteModal<?php echo $row['id']; ?>">View Note</button>

            <!-- Modal -->
            <div class="modal fade" id="noteModal<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel<?php echo $row['id']; ?>" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark text-green">
                  <div class="modal-header">
                    <h5 class="modal-title" id="noteModalLabel<?php echo $row['id']; ?>">Flag Note</h5>
                    <button type="button" class="close text-green" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php echo htmlentities($row['notes']); ?>
                  </div>
                </div>
              </div>
            </div>
        <?php } else {
            echo htmlentities($row['notes']);
        } ?>
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
