<?php
// ctf-multi.php — Hacker.css styled multi-challenge CTF page
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CTF Challenges</title>
    <link rel="stylesheet" href="css/hacker.css">
    <!-- Bootstrap JS for tabs -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">CTF Platform</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Challenges</a></li>
                <li><a href="#">Scoreboard</a></li>
                <li><a href="#">Profile</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <h1 class="text-primary">Capture The Flag Challenges</h1>
        <p class="lead">Switch between categories and solve challenges.</p>

        <hr>

        <!-- Tabs -->
        <ul class="nav nav-tabs">
            <li class="active"><a href="#web" data-toggle="tab">Web</a></li>
            <li><a href="#crypto" data-toggle="tab">Crypto</a></li>
            <li><a href="#pwn" data-toggle="tab">Pwn</a></li>
        </ul>

        <div class="tab-content" style="margin-top:20px;">
            <!-- Web Challenges -->
            <div class="tab-pane fade in active" id="web">
                <h2>Web Challenges</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Title</th><th>Points</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>SQL Injection Basics</td>
                            <td>100</td>
                            <td><span class="text-danger">Unsolved</span></td>
                        </tr>
                        <tr>
                            <td>XSS Playground</td>
                            <td>150</td>
                            <td><span class="text-danger">Unsolved</span></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Challenge: SQL Injection Basics</h3>
                <p>Bypass the login form using SQL injection. The flag is hidden in the admin panel.</p>
                <pre><code>Hint: Try using ' OR '1'='1</code></pre>

                <form>
                    <div class="form-group">
                        <label for="flag1">Submit Flag:</label>
                        <input type="text" id="flag1" class="form-control" placeholder="CTF{your_flag_here}">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>

            <!-- Crypto Challenges -->
            <div class="tab-pane fade" id="crypto">
                <h2>Crypto Challenges</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Title</th><th>Points</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Caesar Cipher</td>
                            <td>50</td>
                            <td><span class="text-success">Solved</span></td>
                        </tr>
                        <tr>
                            <td>RSA Weak Keys</td>
                            <td>200</td>
                            <td><span class="text-danger">Unsolved</span></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Challenge: Caesar Cipher</h3>
                <p>Decrypt the given ciphertext and submit the flag.</p>
                <pre><code>Encrypted: ZHOFRPH WR WKH FWI!</code></pre>

                <form>
                    <div class="form-group">
                        <label for="flag2">Submit Flag:</label>
                        <input type="text" id="flag2" class="form-control" placeholder="CTF{your_flag_here}">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>

            <!-- Pwn Challenges -->
            <div class="tab-pane fade" id="pwn">
                <h2>Pwn Challenges</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr><th>Title</th><th>Points</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Buffer Overflow</td>
                            <td>200</td>
                            <td><span class="text-danger">Unsolved</span></td>
                        </tr>
                        <tr>
                            <td>Format String Attack</td>
                            <td>250</td>
                            <td><span class="text-danger">Unsolved</span></td>
                        </tr>
                    </tbody>
                </table>

                <h3>Challenge: Buffer Overflow</h3>
                <p>Exploit the vulnerable binary to get a shell and read the flag.</p>
                <pre><code>Binary: vuln32</code></pre>

                <form>
                    <div class="form-group">
                        <label for="flag3">Submit Flag:</label>
                        <input type="text" id="flag3" class="form-control" placeholder="CTF{your_flag_here}">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>

        <hr>

        <!-- Scoreboard -->
        <h2>Scoreboard</h2>
        <table class="table table-bordered">
            <thead>
                <tr><th>Rank</th><th>Team</th><th>Points</th></tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Team Alpha</td><td>500</td></tr>
                <tr><td>2</td><td>Shetti</td><td>400</td></tr>
                <tr><td>3</td><td>Team Beta</td><td>350</td></tr>
            </tbody>
        </table>

    </div>

    <!-- Footer -->
    <footer class="footer text-center" style="margin-top:40px; padding:20px; border-top:1px solid #030;">
        <p>&copy; 2025 CTF Platform — Powered by hacker.css 💀</p>
    </footer>

</body>
</html>
