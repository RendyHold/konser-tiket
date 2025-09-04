import '../resources/js/bootstrap';
import '../css/app.css';

import { createApp } from 'vue';

import Alpine from 'alpinejs';
import Festival from './components/Festival.vue'

createApp(Festival).mount('#app')

window.Alpine = Alpine;

Alpine.start();


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