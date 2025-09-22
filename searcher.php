<?php
// search_page.php
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Search by CTFID</title>
  <link rel="stylesheet" href="css/hacker.css">
  <style>
    .modal { display:none; position:fixed; z-index:999; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.75); }
    .modal-content { background:#0b0b0b; color:#9cff9c; margin:4% auto; padding:18px; border:2px solid #0f0; width:88%; max-height:82%; overflow:auto; border-radius:8px; }
    .close { float:right; cursor:pointer; color:#ff6b6b; font-size:22px; }
    .search-box { text-align:center; margin:18px 0; }
    .hacker-input { width:40%; max-width:420px; }
    .hacker-btn { margin-left:8px; }
    .modal-content table { width:100%; border-collapse:collapse; }
    .modal-content th, .modal-content td { padding:6px 8px; border:1px solid rgba(0,255,0,0.08); font-size:13px; text-align:left; vertical-align:top; }
  </style>
</head>
<body>

<div class="search-box">
  <input id="searchInput" class="hacker-input" type="text" placeholder="Enter CTFID">
  <button id="searchBtn" class="hacker-btn">Search</button>
</div>

<div id="resultModal" class="modal">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <div id="resultContent">Waiting for search…</div>
  </div>
</div>

<div class="main-page">
</div>

<script>
  const btn = document.getElementById('searchBtn');
  const input = document.getElementById('searchInput');
  const modal = document.getElementById('resultModal');
  const content = document.getElementById('resultContent');
  const closeBtn = document.getElementById('closeModal');

  function openModal() { modal.style.display = 'block'; }
  function closeModal() { modal.style.display = 'none'; }

  function searchAccounts() {
    const q = input.value.trim();
    if (!q) return;
    content.innerHTML = "Searching...";
    fetch("search.php", {
      method: "POST",
      headers: { "Content-Type": "application/x-www-form-urlencoded" },
      body: "query=" + encodeURIComponent(q)
    })
    .then(r => r.text())
    .then(html => { content.innerHTML = html; openModal(); })
    .catch(err => { content.innerHTML = "Error: " + err; openModal(); });
  }

  btn.addEventListener('click', searchAccounts);
  input.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); searchAccounts(); }});
  closeBtn.addEventListener('click', closeModal);
  window.addEventListener('click', e => { if (e.target === modal) closeModal(); });
</script>

</body>
</html>
