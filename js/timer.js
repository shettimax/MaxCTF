function updateCountdowns() {
  const countdowns = document.querySelectorAll('.countdown');
  countdowns.forEach(el => {
    const endTime = new Date(el.getAttribute('data-end')).getTime();
    const now = new Date().getTime();
    const diff = endTime - now;

    if (diff <= 0) {
      el.textContent = 'Expired';
      el.classList.add('text-danger');

      const parent = el.closest('li');
      const launchLink = parent.querySelector('.launch-link');
      if (launchLink) {
        launchLink.classList.add('disabled');
        launchLink.removeAttribute('href');
        launchLink.textContent = '';
      }
    } else {
      const hours = Math.floor(diff / (1000 * 60 * 60));
      const minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((diff % (1000 * 60)) / 1000);
      el.textContent = `${hours}h ${minutes}m ${seconds}s`;
    }
  });
}

setInterval(updateCountdowns, 1000);
updateCountdowns();

