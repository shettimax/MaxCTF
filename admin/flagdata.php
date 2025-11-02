<?php
include 'config.php';
$get = mysqli_query($conn,"SELECT * FROM reportx WHERE status='pending'");
echo '<table class="table table-bordered text-green"><thead><tr>
<th>ID</th><th>CTFID</th><th>Points</th><th>Bug / Severity</th><th>Proof</th><th>Action</th></tr></thead><tbody>';
while($row = mysqli_fetch_array($get)){
echo '<tr>
<td>'.$row['id'].'</td>
<td>'.$row['walletid'].'</td>
<td>'.$row['amount'].'</td>
<td>'.$row['bug'].' '.$row['severity'].'</td>
<td><a href="../../'.$row['proofimage'].'" target="_blank"><img src="../../'.$row['proofimage'].'" width="150px"></a></td>
<td>
<input type="text" class="form-control mb-2 note-input" placeholder="Approval note">
<button class="btn btn-success btn-sm approve-btn" data-id="'.$row['id'].'" data-wallet="'.$row['walletid'].'" data-amount="'.$row['amount'].'">Approve</button>
<input type="text" class="form-control mb-2 note-input" placeholder="Rejection reason">
<button class="btn btn-danger btn-sm reject-btn" data-id="'.$row['id'].'" data-wallet="'.$row['walletid'].'">Reject</button>
</td></tr>';
}
echo '</tbody></table>';
