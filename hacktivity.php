<?php
include 'confik.php';

$feed = mysqli_query($conn, "
    SELECT walletid, bug, severity, amount, status, date
    FROM reportx r1
    WHERE date = (
        SELECT MAX(date)
        FROM reportx r2
        WHERE r2.walletid = r1.walletid
    )
    ORDER BY date DESC
    LIMIT 15
");

while ($row = mysqli_fetch_assoc($feed)) {
    $tag = ($row['status'] === 'approved') ? '✔' : '✖';
    echo "<li class='list-group-item'>[$tag] " . htmlentities($row['walletid']) . " flagged <em>" . htmlentities($row['bug']) . "</em> (" . htmlentities($row['severity']) . ") — <span class='badge'>" . htmlentities($row['amount']) . " pts</span></li>";
}
?>
