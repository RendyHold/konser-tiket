<template>
    <div id="wrapper" class="wrapper">
      <!-- HERO -->
      <section class="hero overlay">
        <div class="main-slider slider">
          <!-- Swiper container -->
          <div class="swiper">
            <div class="swiper-wrapper">
              <div class="swiper-slide">
                <div class="background-img">
                  <img src="/img/1.jpg" alt="Suasana Festival Mahasiswa" loading="lazy" />
                </div>
              </div>
            </div>
            <div class="swiper-pagination"></div>
          </div>
        </div>

        <!-- HEADER + INNER HERO (copy dari HTML kamu) -->
        <!-- ... -->
      </section>

      <!-- ABOUT / SCHEDULE / COUNTER / SPONSOR / LOCATION / FAQ / GALLERY / FOOTER -->
      <!-- Tempel seluruh section dari file HTML rapi yang sudah kuberi -->
    </div>
  </template>

  <script setup>
  import { onMounted } from 'vue'
  import dayjs from 'dayjs'
  import SmoothScroll from 'smooth-scroll'
  import GLightbox from 'glightbox'
  import Swiper, { Pagination, Autoplay } from 'swiper'

  // CSS untuk lib (atau import global di main.js)
  import 'swiper/css'
  import 'swiper/css/pagination'
  import 'glightbox/dist/css/glightbox.css'

  onMounted(() => {
    // Smooth scroll untuk anchor .scroll
    new SmoothScroll('a.scroll[href*="#"]', { speed: 600, offset: 0 })

    // Lightbox (ganti venobox -> glightbox)
    GLightbox({ selector: '.venobox' })

    // Slider (ganti flexslider -> swiper)
    Swiper.use([Pagination, Autoplay])
    new Swiper('.swiper', {
      loop: true,
      autoplay: { delay: 4000 },
      pagination: { el: '.swiper-pagination', clickable: true }
    })

    // Countdown (ganti jquery.countdown)
    const el = document.querySelector('.countdown')
    if (el) {
      const target = dayjs('2025-09-28T00:00:00')
      const tick = () => {
        const now = dayjs()
        const diff = target.diff(now)
        if (diff <= 0) {
          el.textContent = 'Festival started!'
          return
        }
        const d = Math.floor(diff / (1000 * 60 * 60 * 24))
        const h = Math.floor((diff / (1000 * 60 * 60)) % 24)
        const m = Math.floor((diff / (1000 * 60)) % 60)
        const s = Math.floor((diff / 1000) % 60)
        el.textContent = `${d}d ${h}h ${m}m ${s}s`
        requestAnimationFrame(tick)
      }
      tick()
    }
  })
  </script>

  <!-- kamu tetap pakai CSS existing (bootstrap/base/main). Bisa link via index.html atau import di main.js -->
