// public/js/fm.js
(function () {
    const qs  = (s, c = document) => c.querySelector(s);
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

      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        backdrop.hidden = true;
        nav.appendChild(backdrop);
      }

      const open = () => {
        nav.classList.add('is-open');
        toggle && toggle.setAttribute('aria-expanded','true');
        if (menu) menu.hidden = false;
        backdrop.hidden = false;
        backdrop.classList.add('show');
        document.body.classList.add('nav-open');
      };

      const close = () => {
        nav.classList.remove('is-open');
        toggle && toggle.setAttribute('aria-expanded','false');
        if (menu) menu.hidden = true;
        backdrop.classList.remove('show');
        backdrop.hidden = true;
        document.body.classList.remove('nav-open');
      };

      const toggleMenu = (e) => {
        e.preventDefault();
        e.stopPropagation();
        nav.classList.contains('is-open') ? close() : open();
      };

      toggle && toggle.addEventListener('click', toggleMenu, {passive:false});
      toggle && toggle.addEventListener('touchend', toggleMenu, {passive:false});
      backdrop.addEventListener('click', close, {passive:true});
      menu && menu.addEventListener('click', (e) => { if (e.target.closest('a')) close(); }, {passive:true});
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });
      window.addEventListener('resize', () => { if (window.innerWidth >= 768 && nav.classList.contains('is-open')) close(); });
    });
  })();
