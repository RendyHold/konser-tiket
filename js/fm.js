// public/js/fm.js
(function () {
    const qs   = (s, c = document) => c.querySelector(s);
    const qsa  = (s, c = document) => Array.from(c.querySelectorAll(s));
    const BP   = 768; // breakpoint desktop

    const ready = (fn) => {
      if (document.readyState !== 'loading') fn();
      else document.addEventListener('DOMContentLoaded', fn);
    };

    ready(() => {
      const nav = qs('.main-nav');
      if (!nav) return;

      const toggle   = qs('.mobile-but', nav);
      const menu     = qs('#mainMenu.nav-list', nav) || qs('.nav-list', nav);
      let   backdrop = qs('.nav-backdrop', nav) || qs('.nav-backdrop');

      // auto-bikin backdrop kalau belum ada
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        backdrop.hidden = true;
        nav.appendChild(backdrop);
      }

      // helper: kandidat fokus di dalam menu
      const focusablesSel = 'a[href], button:not([disabled]), [tabindex]:not([tabindex="-1"])';

      // cegah scroll layar belakang di mobile ketika menu buka
      function lockScrollTouch(e){
        // ijinkan scroll jika gesture berasal dari dalam panel menu
        if (!menu.contains(e.target)) e.preventDefault();
      }

      function open() {
        nav.classList.add('is-open');
        toggle && toggle.setAttribute('aria-expanded', 'true');

        // tampilkan panel + backdrop
        if (menu) menu.hidden = false;
        backdrop.hidden = false;
        backdrop.classList.add('show');

        // kunci scroll
        document.body.classList.add('nav-open');
        document.addEventListener('touchmove', lockScrollTouch, { passive: false });

        // fokus ke item pertama demi aksesibilitas
        const first = menu && qs(focusablesSel, menu);
        if (first) first.focus({ preventScroll: true });
      }

      function close() {
        nav.classList.remove('is-open');
        toggle && toggle.setAttribute('aria-expanded', 'false');

        // sembunyikan panel + backdrop
        if (menu) menu.hidden = true;
        backdrop.classList.remove('show');
        backdrop.hidden = true;

        // lepas kunci scroll
        document.body.classList.remove('nav-open');
        document.removeEventListener('touchmove', lockScrollTouch, { passive: false });

        // kembalikan fokus ke tombol
        if (toggle) toggle.focus({ preventScroll: true });
      }

      function toggleMenu(e){
        e.preventDefault();
        e.stopPropagation();
        nav.classList.contains('is-open') ? close() : open();
      }

      // — events utama —
      if (toggle) {
        toggle.addEventListener('click', toggleMenu, { passive: false });
        toggle.addEventListener('touchend', toggleMenu, { passive: false });
      }

      backdrop.addEventListener('click', close, { passive: true });

      // klik link di dalam menu → tutup
      if (menu) {
        menu.addEventListener('click', (e) => {
          if (e.target && e.target.closest('a')) close();
        }, { passive: true });
      }

      // klik di luar nav saat terbuka → tutup
      document.addEventListener('click', (e) => {
        if (!nav.classList.contains('is-open')) return;
        if (!nav.contains(e.target)) close();
      });

      // ESC
      document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') close();
      });

      // auto-close saat resize ke desktop / orientation berubah
      const maybeClose = () => {
        if (window.innerWidth >= BP && nav.classList.contains('is-open')) close();
      };
      window.addEventListener('resize', maybeClose);
      window.addEventListener('orientationchange', maybeClose);

      // pindah hash (single-page anchors) → tutup
      window.addEventListener('hashchange', () => { if (nav.classList.contains('is-open')) close(); });

      // inisialisasi awal: pastikan menu hidden di mobile
      if (menu) menu.hidden = true;
      backdrop.hidden = true;
    });
  })();
