<?php
ob_start();
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if (empty($_SESSION['alogin']) || $_SESSION['role'] !== 'admin') {
    header('location:index.php');
    exit();
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
    $note = isset($row['notes']) ? trim($row['notes']) : '';
    $modalId = 'noteModal' . intval($row['id']);
?>
<tr>
    <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['walletid'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['bug'] . ' ' . $row['severity'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
        <?php if($row['status']=='approved'){ ?>
            <span class="badge badge-success">Verified</span>
        <?php } elseif($row['status']=='rejected'){ ?>
            <span class="badge badge-danger">Rejected</span>
        <?php } ?>
    </td>
    <td>
        <?php if(strlen($note) > 40){ ?>
            <button class="btn btn-info btn-sm" data-toggle="modal" data-target="#<?php echo $modalId; ?>">View Note</button>

            <!-- Modal -->
            <div class="modal fade" id="<?php echo $modalId; ?>" tabindex="-1" role="dialog" aria-labelledby="<?php echo $modalId; ?>Label" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content bg-dark text-green">
                  <div class="modal-header">
                    <h5 class="modal-title" id="<?php echo $modalId; ?>Label">Flag Note</h5>
                    <button type="button" class="close text-green" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <?php echo nl2br(htmlspecialchars($note, ENT_QUOTES, 'UTF-8')); ?>
                  </div>
                </div>
              </div>
            </div>
        <?php } else {
            echo nl2br(htmlspecialchars($note, ENT_QUOTES, 'UTF-8'));
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

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

<!-- DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
$(document).ready(function() {
    $('#dataTable').DataTable();
});
</script>