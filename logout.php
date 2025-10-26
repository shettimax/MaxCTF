<?php
session_start();
include 'confik.php';

// Award 5 points if user is logged in, means they have time to follow flows to have logout
if (isset($_SESSION['ctfid'])) {
    $ctfid = mysqli_real_escape_string($conn, $_SESSION['ctfid']);
    mysqli_query($conn, "UPDATE accounts SET ctfscore = ctfscore + 6 WHERE ctfid='$ctfid'");
}

// Clear session
$_SESSION = array();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Logging Out...</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/alert.css">
    <style>
        body {
            background-color: #000;
            font-family: 'Courier New', monospace;
            color: #0f0;
        }
    </style>
</head>
<body>
<script>
let countdown = 10;

Swal.fire({
    title: "👋 Logged Out",
    html: "Cyber hygiene respected.<br>Redirecting in <strong><span id='countdown'>" + countdown + "</span></strong> seconds...",
    icon: "info",
    background: "#0f0f0f",
    color: "#0f0",
    showConfirmButton: false,
    allowOutsideClick: false,
    allowEscapeKey: false
});

let timer = setInterval(() => {
    countdown--;
    document.getElementById('countdown').textContent = countdown;
    if (countdown <= 0) {
        clearInterval(timer);
        window.location.href = "login.php";
    }
}, 1000);
</script>
</body>
</html>
