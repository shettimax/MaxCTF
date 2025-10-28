<?php include 'header2.php'; ?>
<div class="container">
  <h2>🎨 Theme Switcher</h2>
  <p>Select your preferred theme:</p>

  <div class="btn-group" role="group">
    <button onclick="setTheme('light-mode')" class="btn btn-default">🌞 Light</button>
    <button onclick="setTheme('dark-mode')" class="btn btn-default">🌙 Dark</button>
    <button onclick="setTheme('hacker-mode')" class="btn btn-default">💻 Hacker</button>
  </div>

  <hr>
  <p><strong>Current Theme:</strong> <span id="theme-label">Loading...</span>
In header2.php, right after body, add:
  script
  const savedTheme = localStorage.getItem('theme') || 'light-mode';
  document.body.className = savedTheme;
script

This ensures every page respects the selected theme.
 </p>
</div>

<style>
body.light-mode {
  background-color: #f5f5f5;
  color: #222;
}
body.light-mode .alert {
  background-color: #fff;
  border-color: #ccc;
}

body.dark-mode {
  background-color: #121212;
  color: #eee;
}
body.dark-mode .alert {
  background-color: #1e1e1e;
  border-color: #333;
}

body.hacker-mode {
  background-color: #000;
  color: #00ff99;
}
body.hacker-mode .alert {
  background-color: #001a00;
  border-color: #00ff99;
}
</style>

<script>
function setTheme(theme) {
  document.body.className = theme;
  localStorage.setItem('theme', theme);
  document.getElementById('theme-label').textContent = theme.replace('-mode', '').toUpperCase();
}

window.onload = function() {
  const savedTheme = localStorage.getItem('theme') || 'light-mode';
  document.body.className = savedTheme;
  document.getElementById('theme-label').textContent = savedTheme.replace('-mode', '').toUpperCase();
};
</script>
<?php include 'footer.php'; ?>
