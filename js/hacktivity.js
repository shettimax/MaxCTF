function loadFeed() {
  fetch('hacktivity.php')
    .then(response => response.text())
    .then(data => {
      const feed = document.getElementById('hacktivity-feed');
      feed.innerHTML = data;

      // Scroll to bottom of the parent container (.terminal-feed)
      feed.parentElement.scrollTop = feed.parentElement.scrollHeight;
    });
}

loadFeed(); // Initial load
setInterval(loadFeed, 30000); // Refresh every 30 seconds

