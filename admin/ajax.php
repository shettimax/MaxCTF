<?php
// Start session only once
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if(isset($_POST['action']) && $_POST['action'] == 'confirm'){
    $id = intval($_POST['id']);
    $walletid = mysqli_real_escape_string($conn, $_POST['walletid']);
    $amount = intval($_POST['amount']);
    $note = mysqli_real_escape_string($conn, substr($_POST['note'], 0, 255));
    $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);

    // Validate inputs
    if ($id > 0 && $amount >= 0 && !empty($walletid)) {
        $result = mysqli_query($conn, "SELECT ctfscore FROM accounts WHERE ctfid='$walletid'");
        if(mysqli_num_rows($result) > 0){
            $row = mysqli_fetch_array($result);
            $newscore = $row['ctfscore'] + $amount;

            mysqli_query($conn, "UPDATE accounts SET ctfscore='$newscore' WHERE ctfid='$walletid'");
            mysqli_query($conn, "UPDATE reportx SET status='approved', notes='$note' WHERE id='$id'");
            
            $action = "Approved flag ID $id for $walletid with note: $note";
            mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
            
            echo "success";
        }
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'reject'){
    $id = intval($_POST['id']);
    $walletid = mysqli_real_escape_string($conn, $_POST['walletid']);
    $note = mysqli_real_escape_string($conn, substr($_POST['note'], 0, 255));
    $admin = mysqli_real_escape_string($conn, $_SESSION['alogin']);

    // Validate inputs
    if ($id > 0 && !empty($walletid)) {
        mysqli_query($conn, "UPDATE reportx SET status='rejected', notes='$note' WHERE id='$id'");
        
        $action = "Rejected flag ID $id for $walletid with reason: $note";
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','$action')");
        
        echo "success";
    }
}
?>