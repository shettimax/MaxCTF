<?php
// demo.php — full showcase of hacker.css
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Hacker.css Full Demo</title>
    <link rel="stylesheet" href="css/hacker.css">
    <!-- Bootstrap JS (needed for dropdowns & modals) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Hacker.css</a>
            </div>
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#">Demo</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        Dropdown <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action</a></li>
                        <li><a href="#">Something else</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container">

        <h1>Hacker.css Demo Page</h1>
        <p class="lead">This page demonstrates all major HTML elements styled with <code>hacker.css</code>.</p>

        <hr>

        <!-- Buttons -->
        <h2>Buttons</h2>
        <button class="btn btn-primary">Primary</button>
        <button class="btn btn-success">Success</button>
        <button class="btn btn-info">Info</button>
        <button class="btn btn-warning">Warning</button>
        <button class="btn btn-danger">Danger</button>
        <button disabled>Disabled</button>
        <a href="#" class="btn btn-default">Link Button</a>

        <hr>

        <!-- Forms -->
        <h2>Forms</h2>
        <form>
            <div class="form-group">
                <label for="text">Text Input:</label>
                <input type="text" id="text" class="form-control" placeholder="Enter text">
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" class="form-control" placeholder="Enter email">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" class="form-control">
            </div>

            <div class="form-group">
                <label for="select">Select:</label>
                <select id="select" class="form-control">
                    <option>Option 1</option>
                    <option>Option 2</option>
                </select>
            </div>

            <div class="checkbox">
                <label><input type="checkbox"> Checkbox</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="radio"> Radio 1</label>
            </div>
            <div class="radio">
                <label><input type="radio" name="radio"> Radio 2</label>
            </div>

            <div class="form-group">
                <textarea class="form-control" placeholder="Textarea"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <hr>

        <!-- Tables -->
        <h2>Table</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th><th>Name</th><th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr><td>1</td><td>Alice</td><td>Active</td></tr>
                <tr><td>2</td><td>Bob</td><td>Inactive</td></tr>
            </tbody>
        </table>

        <hr>

        <!-- Lists -->
        <h2>Lists</h2>
        <ul>
            <li>Unordered Item 1</li>
            <li>Unordered Item 2</li>
        </ul>

        <ol>
            <li>Ordered Item 1</li>
            <li>Ordered Item 2</li>
        </ol>

        <ul class="list-inline">
            <li>Inline 1</li>
            <li>Inline 2</li>
            <li>Inline 3</li>
        </ul>

        <hr>

        <!-- Code -->
        <h2>Code Block</h2>
        <pre><code>
function hello() {
    console.log("Hello Hacker.css!");
}
        </code></pre>

        <p>Inline code: <code>&lt;div&gt;Hello&lt;/div&gt;</code></p>
        <p>Keyboard input: <kbd>Ctrl</kbd> + <kbd>C</kbd></p>

        <hr>

        <!-- Blockquote -->
        <h2>Blockquote</h2>
        <blockquote>
            "Hacker.css makes HTML look clean and minimal."
            <footer>— Demo Footer</footer>
        </blockquote>

        <blockquote class="blockquote-reverse">
            "Reverse styled blockquote."
            <footer>— Another Footer</footer>
        </blockquote>

        <hr>

        <!-- Glyphicons -->
        <h2>Glyphicons</h2>
        <p>
            <span class="glyphicon glyphicon-user"></span> User  
            <span class="glyphicon glyphicon-lock"></span> Lock  
            <span class="glyphicon glyphicon-search"></span> Search  
            <span class="glyphicon glyphicon-heart"></span> Heart  
            <span class="glyphicon glyphicon-star"></span> Star  
        </p>

        <hr>

        <!-- Grid System -->
        <h2>Grid System</h2>
        <div class="row">
            <div class="col-xs-4" style="background:#333; padding:10px;">Column 1</div>
            <div class="col-xs-4" style="background:#444; padding:10px;">Column 2</div>
            <div class="col-xs-4" style="background:#555; padding:10px;">Column 3</div>
        </div>

        <div class="row" style="margin-top:10px;">
            <div class="col-xs-6" style="background:#333; padding:10px;">Half Width</div>
            <div class="col-xs-6" style="background:#444; padding:10px;">Half Width</div>
        </div>

        <hr>

        <!-- Alerts -->
        <h2>Alerts</h2>
        <p class="text-primary">Primary text</p>
        <p class="text-success">Success text</p>
        <p class="text-info">Info text</p>
        <p class="text-warning">Warning text</p>
        <p class="text-danger">Danger text</p>

        <hr>

        <!-- Images -->
        <h2>Images</h2>
        <img src="static.webp" class="img-thumbnail" alt="Thumbnail">
        <img src="static.webp" class="img-circle" alt="Circle">
        <img src="static.webp" class="img-responsive" alt="Responsive">

        <hr>

        <!-- Modal -->
        <h2>Modal</h2>
        <button class="btn btn-info" data-toggle="modal" data-target="#demoModal">Open Modal</button>

        <div class="modal fade" id="demoModal" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content" style="color:#0c0; background:#222;">
              <div class="modal-header">
                <h4 class="modal-title">Hacker.css Modal</h4>
              </div>
              <div class="modal-body">
                <p>This is a modal styled with hacker.css.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

    </div>

    <!-- Footer -->
    <footer class="footer text-center" style="margin-top:40px; padding:20px; border-top:1px solid #030;">
        <p>&copy; 2025 Hacker.css Demo — Styled in green glory 💀</p>
    </footer>

</body>
</html>
