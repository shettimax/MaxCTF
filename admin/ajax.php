<?php
include 'config.php';
session_start();

if(isset($_POST['action']) && $_POST['action'] == 'confirm'){
    $id = $_POST['id'];
    $walletid = $_POST['walletid'];
    $amount = $_POST['amount'];
    $note = $_POST['note'];
    $admin = $_SESSION['alogin'];

    $result = mysqli_query($conn, "SELECT ctfscore FROM accounts WHERE ctfid='$walletid'");
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_array($result);
        $newscore = $row['ctfscore'] + $amount;

        mysqli_query($conn, "UPDATE accounts SET ctfscore='$newscore' WHERE ctfid='$walletid'");
        mysqli_query($conn, "UPDATE reportx SET status='approved', notes='$note' WHERE id='$id'");
        mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','Approved flag ID $id for $walletid with note: $note')");
    }
}

if(isset($_POST['action']) && $_POST['action'] == 'reject'){
    $id = $_POST['id'];
    $walletid = $_POST['walletid'];
    $note = $_POST['note'];
    $admin = $_SESSION['alogin'];

    mysqli_query($conn, "UPDATE reportx SET status='rejected', notes='$note' WHERE id='$id'");
    mysqli_query($conn, "INSERT INTO auditlog (admin, action) VALUES ('$admin','Rejected flag ID $id for $walletid with reason: $note')");
}
?>
