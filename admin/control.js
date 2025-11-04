// /js/control.js

function loadFlags() {
    $.get('flagdata.php', function (data) {
        $('#flagTable').html(data);
    });
}

function loadModFlags() {
    $.get('modflagdata.php', function (data) {
        $('#modFlagTable').html(data);
    });
}

function showAlert(message, type) {
  Swal.fire({
    toast: true,
    position: 'top-end',
    icon: type,
    title: message,
    showConfirmButton: false,
    timer: 9000,
    timerProgressBar: true
  });
}


function bindFlagActions() {
    $(document).on('click', '.approve-btn', function () {
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
        }, function () {
            showAlert('Flag approved successfully 💀', 'success');
            if ($('#flagTable').length) loadFlags();
            if ($('#modFlagTable').length) loadModFlags();
        });
    });

    $(document).on('click', '.reject-btn', function () {
        const btn = $(this);
        const id = btn.data('id');
        const walletid = btn.data('wallet');
        const note = btn.prev('.note-input').val();

        $.post('ajax.php', {
            action: 'reject',
            id: id,
            walletid: walletid,
            note: note
        }, function () {
            showAlert('Flag rejected with reason 💀', 'error');
            if ($('#flagTable').length) loadFlags();
            if ($('#modFlagTable').length) loadModFlags();
        });
    });
}

$(document).ready(function () {
    if ($('#flagTable').length) loadFlags();
    if ($('#modFlagTable').length) loadModFlags();
    bindFlagActions();
});

