<?php
ob_start();
session_start();
error_reporting(0);
include 'config.php';

if(strlen($_SESSION['alogin'])==0 || $_SESSION['role'] != 'mod'){
    header('location:index.php');
}
ob_end_flush();
?>
<?php include 'header.php'; ?>
<link rel="stylesheet" href="alert.css">
<link rel="stylesheet" href="hacker.css">
<div id="layoutSidenav_content">
<main>
<div class="container-fluid">
<h1 class="mt-4"><i class="fas fa-user-shield"></i> Moderator Panel</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
    <li class="breadcrumb-item active">Flag queue for moderators</li>
</ol>

<div class="card mb-4">
<div class="card-header text-green">Assigned Flags</div>
<div class="card-body">
<div class="table-responsive" id="modFlagTable">
<!-- Table will be loaded via AJAX -->
</div>
</div>
</div>
</div>
</main>
<?php include 'footer.php'; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function loadModFlags(){
    $.get('modflagdata.php', function(data){
        $('#modFlagTable').html(data);
    });
}

function showAlert(message, type){
    const alertBox = $('<div class="alert '+type+'">'+message+'</div>');
    $('body').append(alertBox);
    setTimeout(function(){
        alertBox.fadeOut(500, function(){ alertBox.remove(); });
    }, 3000);
}

$(document).ready(function(){
    loadModFlags();

    $(document).on('click', '.approve-btn', function(){
        const btn = $(this);
        const id = btn.data('id');
        const walletid = btn.data('wallet');
        const amount = btn.data('amount');
        const note = btn.prev('.note-input').val();

        $.post('ajax.php', {
            action: 'confirm',
            id: id,
            walletid: walletid,
            amount: amount,
            note: note
        }, function(){
            showAlert('✅ Flag approved', 'success');
            loadModFlags();
        });
    });

    $(document).on('click', '.reject-btn', function(){
        const btn = $(this);
        const id = btn.data('id');
        const walletid = btn.data('wallet');
        const note = btn.prev('.note-input').val();

        $.post('ajax.php', {
            action: 'reject',
            id: id,
            walletid: walletid,
            note: note
        }, function(){
            showAlert('❌ Flag rejected', 'danger');
            loadModFlags();
        });
    });
});
</script>
