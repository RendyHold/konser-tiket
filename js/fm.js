// public/js/fm.js
(function () {
    const qs  = (s, c = document) => c.querySelector(s);
    const ready = (fn) => {
      if (document.readyState !== 'loading') fn();
      else document.addEventListener('DOMContentLoaded', fn);
    };

    ready(() => {
      const nav    = qs('.main-nav');
      if (!nav) return;

      const toggle   = qs('.mobile-but', nav);
      const menu     = qs('#mainMenu.nav-list', nav) || qs('.nav-list', nav);
      let   backdrop = qs('.nav-backdrop', nav) || qs('.nav-backdrop');

      // kalau lupa bikin backdrop di HTML, auto-bikin
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        backdrop.hidden = true;
        nav.appendChild(backdrop);
      }

      const open = () => {
        nav.classList.add('is-open');
        toggle?.setAttribute('aria-expanded','true');
        backdrop.hidden = false;
        backdrop.classList.add('show');
        document.body.classList.add('nav-open'); // lock scroll pakai class
      };

      const close = () => {
        nav.classList.remove('is-open');
        toggle?.setAttribute('aria-expanded','false');
        backdrop.hidden = true;
        backdrop.classList.remove('show');
        document.body.classList.remove('nav-open');
      };

      const toggleMenu = (e) => {
        e.preventDefault();
        e.stopPropagation();
        nav.classList.contains('is-open') ? close() : open();
      };

      // Click & touch untuk Android/iOS
      toggle?.addEventListener('click', toggleMenu, {passive:false});
      toggle?.addEventListener('touchend', toggleMenu, {passive:false});

      backdrop.addEventListener('click', close, {passive:true});

      // Tutup menu jika user klik salah satu link
      menu?.addEventListener('click', (e) => {
        if (e.target.closest('a')) close();
      }, {passive:true});

      // Tutup menu saat ESC ditekan
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

      // Tutup otomatis saat resize ke desktop
      window.addEventListener('resize', () => {
        if (window.innerWidth >= 768 && nav.classList.contains('is-open')) {
          close();
        }
      });
    });
})();
