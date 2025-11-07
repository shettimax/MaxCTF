<?php
ob_start();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>M4XCTF BB - Flag History</title>
    <link rel="icon" type="image/x-icon" href="/favi.ico">
    <link href="css/hacker.css" rel="stylesheet" />
    <link href="css/alert.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
</head>
<body class="sb-nav-fixed" style="background-color: #000; color: #00ff99;">
<nav class="navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand text-green" href="dashboard.php">MAXCTFBB</a>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item"><a class="nav-link text-green" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
    </ul>
</nav>
<div id="layoutSidenav">
<div id="layoutSidenav_nav">
<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <a class="nav-link text-green" href="dashboard.php"><i class="fas fa-terminal"></i> </a>|
            <a class="nav-link text-green" href="flags.php"><i class="fas fa-bug"></i> Flags</a>|
            <a class="nav-link text-green" href="ctflog.php"><i class="fas fa-history"></i> Flag History</a>|
            <a class="nav-link text-green" href="solves.php"><i class="fas fa-check-double"></i> Solves</a>|
            <a class="nav-link text-green" href="userz.php"><i class="fas fa-users"></i> Users</a>|
            <a class="nav-link text-green" href="badges.php"><i class="fas fa-award"></i> Badges</a>|
            <a class="nav-link text-green" href="challenges.php"><i class="fas fa-puzzle-piece"></i> Challenges</a>|
            <a class="nav-link text-green" href="targets.php"><i class="fas fa-crosshairs"></i> Targets</a>|
            <a class="nav-link text-green" href="modpanel.php"><i class="fas fa-user-shield"></i> Mod Panel</a>|
            <a class="nav-link text-green" href="analytics.php"><i class="fas fa-chart-bar"></i> Analytics</a>
            <div class="sb-sidenav-menu-heading text-green">|</div>
            <a class="nav-link text-green" href="addadmin.php"><i class="fas fa-user-plus"></i> Add Admin</a>|
            <a class="nav-link text-green" href="viewadmins.php"><i class="fas fa-users-cog"></i> View Admins</a>|
            <a class="nav-link text-green" href="auditlog.php"><i class="fas fa-clipboard-list"></i> Audit Log</a>|
        </div>
    </div>
</nav>
</div>
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-history"></i> Flag History</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Approved & Rejected Flags</li>
</ol>

<div class="card mb-4">
<div class="card-header">Flag Log</div>
<div class="card-body">
<div class="table-responsive">
<table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
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
if(mysqli_num_rows($get) > 0) {
    while($row = mysqli_fetch_array($get)){
        $note = isset($row['notes']) ? trim($row['notes']) : '';
?>
<tr>
    <td><?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['walletid'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['amount'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td><?php echo htmlspecialchars($row['bug'] . ' / ' . $row['severity'], ENT_QUOTES, 'UTF-8'); ?></td>
    <td>
        <?php if($row['status']=='approved'){ ?>
            <span class="badge badge-success">Verified</span>
        <?php } elseif($row['status']=='rejected'){ ?>
            <span class="badge badge-danger">Rejected</span>
        <?php } ?>
    </td>
    <td>
        <?php if(!empty($note)) { ?>
            <?php if(strlen($note) > 40){ ?>
                <button type="button" class="btn btn-info btn-sm view-note-btn" 
                        data-note="<?php echo htmlspecialchars($note, ENT_QUOTES, 'UTF-8'); ?>"
                        data-id="<?php echo htmlspecialchars($row['id'], ENT_QUOTES, 'UTF-8'); ?>">
                    View Note
                </button>
            <?php } else {
                echo '<div class="small">' . nl2br(htmlspecialchars($note, ENT_QUOTES, 'UTF-8')) . '</div>';
            } ?>
        <?php } else { ?>
            <span class="text-muted">No note</span>
        <?php } ?>
    </td>
</tr>
<?php } 
} else { ?>
    <tr>
        <td colspan="6" class="text-center">No approved or rejected flags found.</td>
    </tr>
<?php } ?>
</tbody>
</table>
</div>
</div>
</div>
</div>
</main>

<!-- Single Modal - Fixed ARIA attributes -->
<div class="modal" id="noteModal" tabindex="-1" role="dialog" aria-labelledby="noteModalLabel" aria-modal="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content bg-dark text-light">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="noteModalLabel">Flag Note - ID: <span id="modalId"></span></h5>
                <button type="button" class="close text-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="p-3 bg-dark border border-secondary rounded">
                    <div id="modalNoteContent"></div>
                </div>
            </div>
            <div class="modal-footer border-secondary">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<footer class="py-4 bg-dark mt-auto">
    <div class="container-fluid">
        <div class="text-center text-green">CTFBACKBOX | MZGZ</div>
    </div>
</footer>
</div>
</div>

<!-- JavaScript Files -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
// Proper JavaScript without CSP violations
document.addEventListener('DOMContentLoaded', function() {
    // Initialize DataTable with custom search input attributes
    $('#dataTable').DataTable({
        pageLength: 25,
        order: [[0, "desc"]],
        responsive: true,
        language: {
            emptyTable: "No flag history available",
            zeroRecords: "No matching records found",
            search: "Search:"
        },
        initComplete: function() {
            // Add proper attributes to DataTables search input
            var searchInput = $('.dataTables_filter input');
            searchInput.attr('id', 'datatable-search');
            searchInput.attr('name', 'search');
            searchInput.attr('autocomplete', 'off');
            searchInput.attr('aria-label', 'Search flag history');
        }
    });

    // Handle modal note display with proper focus management
    var viewNoteButtons = document.querySelectorAll('.view-note-btn');
    var noteModal = document.getElementById('noteModal');
    
    viewNoteButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            var note = this.getAttribute('data-note');
            var id = this.getAttribute('data-id');
            
            document.getElementById('modalId').textContent = id;
            document.getElementById('modalNoteContent').textContent = note;
            
            // Show modal using jQuery (Bootstrap 4)
            $('#noteModal').modal('show');
            
            // Fix for ARIA issues - remove aria-hidden when modal is shown
            $('#noteModal').on('shown.bs.modal', function() {
                $(this).removeAttr('aria-hidden');
                $(this).attr('aria-modal', 'true');
            });
            
            // Restore aria-hidden when modal is hidden
            $('#noteModal').on('hidden.bs.modal', function() {
                $(this).attr('aria-hidden', 'true');
                $(this).removeAttr('aria-modal');
            });
        });
    });

    // Auto-hide alerts
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert-warning');
        alerts.forEach(function(alert) {
            alert.style.display = 'none';
        });
    }, 3000);
});
</script>
</body>
</html>