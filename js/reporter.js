document.addEventListener('DOMContentLoaded', function () {
  const notesField = document.getElementById('notes');
  const charCount = document.getElementById('charCount');
  const submitBtn = document.getElementById('submitBtn');

  function updateState() {
    const count = notesField.value.trim().length;
    charCount.textContent = count;
    submitBtn.disabled = count === 0;
    if (count > 120) {
      notesField.value = notesField.value.substring(0, 120);
      charCount.textContent = 120;
    }
  }

  notesField.addEventListener('input', updateState);
  updateState();
});

