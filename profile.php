<?php
ob_start();
ini_set('display_errors', 0);
error_reporting(E_ALL);
session_start();
include 'confik.php';

if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header('location:disclaimer.php');
    exit();
}

$ctfid = $_SESSION['id'];
$result = mysqli_query($conn, "SELECT * FROM accounts WHERE ctfid='$ctfid'");
$row = mysqli_fetch_array($result);

$_SESSION['ctfid'] = $row['ctfid'];
$_SESSION['ctfname'] = $row['ctfname'];

ob_end_flush();
?>

<?php include 'header2.php'; ?>

<!-- Terminal-styled challenge message -->
<div class="terminal-scroll">
almost there buddy!
you wanna lead the scoreboard huh?
crack this: cmVwb3J0ZXI=
----------------------------------
hint: load whatyougotfromcrackingit.php to submit a report/captured flag
----------hint2 0x64617368626f617264.php holds signal you need
~goodluck!
</div>

<!-- SweetAlert2 + alert.css -->
<link rel="stylesheet" href="css/alert.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php 
if (isset($_SESSION['error'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Oops!',
        text: "<?php echo $_SESSION['error']; ?>",
        icon: 'error',
        background: '#0f0f0f',
        color: '#ff0033',
        confirmButtonColor: '#ff0033'
    });
});
</script>
<?php 
unset($_SESSION['error']);
} else if (isset($_SESSION['success'])) {
?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        title: 'Nice!',
        text: "<?php echo $_SESSION['success']; ?>",
        icon: 'success',
        background: '#0f0f0f',
        color: '#00ff99',
        confirmButtonColor: '#00ff99'
    });
});
</script>
<?php 
unset($_SESSION['success']);
} 
?>

<?php include 'footer.php'; ?>
