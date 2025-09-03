// Toggle drawer nav (tanpa jQuery)
document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.main-nav');
    const btn = document.querySelector('.mobile-but');
    const backdrop = document.querySelector('.nav-backdrop');
    const links = document.querySelectorAll('.nav-list a');

    if (!nav || !btn) return;

    const close = () => nav.classList.remove('is-open');

    btn.addEventListener('click', (e) => {
      e.preventDefault();
      nav.classList.toggle('is-open');
    });

    backdrop?.addEventListener('click', close);
    links.forEach(a => a.addEventListener('click', close));
    document.addEventListener('keydown', e => { if (e.key === 'Escape') close(); });
  });

  // public/js/fm.js
(function () {
    const qs  = (s, c = document) => c.querySelector(s);
    const qsa = (s, c = document) => Array.from(c.querySelectorAll(s));

    function ready(fn){
      if (document.readyState !== 'loading') fn();
      else document.addEventListener('DOMContentLoaded', fn);
    }

    ready(() => {
      const nav      = qs('.main-nav');
      if (!nav) return;

      const toggle   = qs('.mobile-but', nav);
      const menu     = qs('.nav-list', nav);
      let backdrop   = qs('.nav-backdrop', nav);

      // kalau lupa bikin backdrop di HTML, auto-bikin
      if (!backdrop) {
        backdrop = document.createElement('div');
        backdrop.className = 'nav-backdrop';
        nav.appendChild(backdrop);
      }

      const open = () => {
        nav.classList.add('is-open');
        toggle.setAttribute('aria-expanded','true');
        backdrop.hidden = false;
        document.body.style.overflow = 'hidden';
      };

      const close = () => {
        nav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded','false');
        backdrop.hidden = true;
        document.body.style.overflow = '';
      };

      const toggleMenu = (e) => {
        e.preventDefault();
        e.stopPropagation();
        nav.classList.contains('is-open') ? close() : open();
      };

      // Click & touch untuk Android/iOS
      toggle.addEventListener('click', toggleMenu, {passive:false});
      toggle.addEventListener('touchend', toggleMenu, {passive:false});

      backdrop.addEventListener('click', close, {passive:true});
      document.addEventListener('keydown', (e) => { if (e.key === 'Escape') close(); });

      // Tutup menu jika user klik salah satu link
      menu.addEventListener('click', (e) => {
        if (e.target.closest('a')) close();
      }, {passive:true});
    });
  })();

