<?php
// scoreboard.php — Hacker.css styled live scoreboard
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CTF Scoreboard</title>
    <link rel="stylesheet" href="css/hacker.css">
    <!-- jQuery + Bootstrap for refresh simulation -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Fake auto-refresh every 10 seconds
        function refreshScoreboard() {
            // In real use, you'd fetch updated scores via AJAX
            console.log("Refreshing scoreboard...");
        }
        setInterval(refreshScoreboard, 10000);
    </script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">CTF Platform</a>
            </div>
            <ul class="nav navbar-nav">
                <li><a href="ctf-multi.php">Challenges</a></li>
                <li class="active"><a href="#">Scoreboard</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <h1 class="text-primary">Live Scoreboard</h1>
        <p class="lead">Updated every 10 seconds to simulate competition.</p>

        <hr>

        <!-- Scoreboard Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Rank</th><th>Team</th><th>Points</th><th>Last Solve</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Team Alpha</td><td>750</td><td>10:01 AM</td></tr>
                <tr><td>2</td><td>Shetti</td><td>700</td><td>10:00 AM</td></tr>
                <tr><td>3</td><td>Team Beta</td><td>650</td><td>9:58 AM</td></tr>
                <tr><td>4</td><td>Team Gamma</td><td>500</td><td>9:55 AM</td></tr>
            </tbody>
        </table>

        <hr>

        <!-- Alerts -->
        <h2>Announcements</h2>
        <p class="text-info">New challenge unlocked: <strong>Reverse Engineering 101</strong></p>
        <p class="text-warning">Hint dropped for Crypto: RSA Weak Keys</p>
        <p class="text-danger">Server reboot scheduled at 11:00 AM</p>

    </div>

    <!-- Footer -->
    <footer class="footer text-center" style="margin-top:40px; padding:20px; border-top:1px solid #030;">
        <p>&copy; 2025 CTF Platform — Powered by hacker.css 💀</p>
    </footer>

</body>
</html>
