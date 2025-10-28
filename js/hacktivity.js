function loadFeed() {
  fetch('hacktivity.php')
    .then(response => response.text())
    .then(data => {
      document.getElementById('hacktivity-feed').innerHTML = data;
    });
}

loadFeed(); // Initial load
setInterval(loadFeed, 30000); // Refresh every 30 seconds

