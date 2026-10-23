/* Click-to-copy ([data-copy], '#' becomes '@' with data-at) and count-up numbers for the about / links pages. */
(function () {
  function copyText(text) {
    if (navigator.clipboard && window.isSecureContext) {
      return navigator.clipboard.writeText(text);
    }
    return new Promise(function (resolve, reject) {
      var area = document.createElement('textarea');
      area.value = text;
      area.setAttribute('readonly', '');
      area.style.position = 'fixed';
      area.style.opacity = '0';
      document.body.appendChild(area);
      area.select();
      try {
        document.execCommand('copy') ? resolve() : reject();
      } catch (e) {
        reject(e);
      } finally {
        document.body.removeChild(area);
      }
    });
  }

  document.addEventListener('click', function (ev) {
    var btn = ev.target.closest ? ev.target.closest('[data-copy]') : null;
    if (!btn) return;
    var text = btn.getAttribute('data-copy');
    // addresses are written with # instead of @ in the markup to stay out of scrapers
    if (btn.hasAttribute('data-at')) text = text.replace('#', '@');
    copyText(text).then(function () {
      btn.classList.add('is-done');
      var tip = btn.querySelector('.sr');
      if (tip) tip.textContent = '已复制';
      setTimeout(function () {
        btn.classList.remove('is-done');
        if (tip) tip.textContent = '复制';
      }, 1600);
    }, function () {});
  });

  document.addEventListener('keydown', function (ev) {
    if ((ev.key === 'Enter' || ev.key === ' ') && ev.target.matches && ev.target.matches('[data-copy]:not(button)')) {
      ev.preventDefault();
      ev.target.click();
    }
  });

  var nums = document.querySelectorAll('.pg-num[data-to]');
  if (!nums.length || (window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches)) return;
  Array.prototype.forEach.call(nums, function (el) {
    var to = parseInt(el.getAttribute('data-to'), 10);
    if (!to) return;
    var start = null, dur = 900;
    function step(ts) {
      if (start === null) start = ts;
      var p = Math.min((ts - start) / dur, 1);
      el.textContent = Math.round(to * (1 - Math.pow(1 - p, 3)));
      if (p < 1) requestAnimationFrame(step);
    }
    el.textContent = '0';
    requestAnimationFrame(step);
  });
})();
