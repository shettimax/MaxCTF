document.addEventListener('DOMContentLoaded', function () {
  document.querySelectorAll('.launch-link').forEach(link => {
    link.addEventListener('click', function (e) {
      e.preventDefault();

      const ctfname = this.getAttribute('data-ctfname');
      const title = this.getAttribute('data-title');
      const category = this.getAttribute('data-category');
      const name = this.getAttribute('data-target');
      const description = this.getAttribute('data-description');
      const launchUrl = this.getAttribute('data-launchurl');

      Swal.fire({
        title: 'Mission Briefing',
        html: `
          <p>Dear <b>${ctfname}</b>, you're about hunting for <b>${title}</b> in <em>${category}</em> under <code>${name}</code>.</p>
          <p>What's expected of you is:<br><code>${description}</code></p>
          <p><b>Good luck</b></p>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Launch',
        cancelButtonText: 'Abort',
        timer: 50000,
        timerProgressBar: true,
        allowOutsideClick: false,
        allowEscapeKey: false,
        didClose: () => {
          if (Swal.getTimerLeft() === 0 && Swal.getConfirmButton().style.display !== 'none') {
            window.location.href = launchUrl;
          }
        },
        preConfirm: () => {
          window.location.href = launchUrl;
        }
      });
    });
  });
});

