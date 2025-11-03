<?php
include 'header.php';
include 'config.php';

// Filter by action keyword
$filter = isset($_GET['action']) ? trim($_GET['action']) : '';
$where = '';

if ($filter) {
    $escaped = mysqli_real_escape_string($conn, $filter);
    $where = "WHERE action LIKE '%$escaped%'";
}

$logs = mysqli_query($conn, "SELECT * FROM auditlog $where ORDER BY timestamp DESC");
?>

<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
    <h1 class="mt-4"><i class="fas fa-clipboard-list"></i> Audit Log</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
        <li class="breadcrumb-item active">Audit Log</li>
    </ol>

    <div class="mb-3">
        <form method="GET" class="form-inline">
            <label class="mr-2 text-green">Filter by action:</label>
            <select name="action" class="form-control mr-2" onchange="this.form.submit()">
                <option value="">All</option>
                <option value="Logged in" <?php if ($filter === 'Logged in') echo 'selected'; ?>>Logged in</option>
                <option value="Created" <?php if ($filter === 'Created') echo 'selected'; ?>>Created</option>
                <option value="Edited" <?php if ($filter === 'Edited') echo 'selected'; ?>>Edited</option>
                <option value="Deleted" <?php if ($filter === 'Deleted') echo 'selected'; ?>>Deleted</option>
                <option value="Approved" <?php if ($filter === 'Approved') echo 'selected'; ?>>Approved</option>
                <option value="Rejected" <?php if ($filter === 'Rejected') echo 'selected'; ?>>Rejected</option>
                <option value="Added" <?php if ($filter === 'Added') echo 'selected'; ?>>Added</option>
            </select>
        </form>
    </div>

    <div class="card mb-4">
        <div class="card-header text-green">Admin Actions</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered text-green" id="auditTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Admin</th>
                            <th>Action</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_array($logs)) { ?>
                        <tr>
                            <td><?php echo htmlentities($row['admin']); ?></td>
                            <td><?php echo htmlentities($row['action']); ?></td>
                            <td><?php echo htmlentities($row['timestamp']); ?></td>
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

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script>
$(document).ready(function () {
    $('#auditTable').DataTable({
        pageLength: 50,
        order: [[2, 'desc']],
        responsive: true
    });
});
</script>
