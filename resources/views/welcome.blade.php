<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <title>Festival Mahasiswa</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="Festival Mahasiswa: konser, pentas seni, bazar, kompetisi—oleh dan untuk mahasiswa kampus." />

  {{-- Fonts --}}
  <link href="https://fonts.googleapis.com/css?family=Work+Sans:300,400,500,600,700&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,700&display=swap" rel="stylesheet" />

  {{-- CSS (letakkan file2 ini di public/css) --}}
  <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('css/base.css') }}">
  <link rel="stylesheet" href="{{ asset('css/main.css') }}">
  <link rel="stylesheet" href="{{ asset('css/flexslider.css') }}">
  <link rel="stylesheet" href="{{ asset('css/venobox.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
  <link rel="stylesheet" href="{{ asset('css/fm.css') }}">

  <link href="{{ asset('css/overrides.css') }}" rel="stylesheet">
</head>

<script src="{{ asset('js/fm.js') }}"></script>
<body>
  {{-- Preloader --}}
  <div class="loader" aria-hidden="true">
    <div class="loader-inner">
      <svg width="120" height="220" viewBox="0 0 100 100" class="loading-spinner" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Loading">
        <circle class="spinner" cx="50" cy="50" r="21" fill="#111111" stroke-width="1.5"/>
      </svg>
    </div>
  </div>

  {{-- Wrapper --}}
  <div class="wrapper" id="wrapper">
    {{-- Hero --}}
    <section id="home" class="hero overlay" aria-label="Beranda">
  <div class="main-slider slider" aria-label="Hero images">
    <ul class="slides">
      <li>
        <div class="background-img">
          <img src="{{ asset('img/1.jpg') }}" alt="Suasana Festival Mahasiswa" loading="lazy">
        </div>
      </li>
    </ul>
  </div>

  <!-- ⬇⬇ INI YANG HILANG: blok inner-hero -->
  <div class="inner-hero">
    <div class="container hero-content">
      <div class="row">
        <div class="col-sm-12 text-center">
          <h3 class="mb-10" style="font-style:italic;">Event Kampus</h3>
          <h1 class="large mb-10">Festival Mahasiswa</h1>
          <p class="uppercase">28 September 2025 — Unindra, Kampus B</p>
          <a href="{{ route('register') }}" class="but scroll">Register Now</a>
        </div>
      </div>
    </div>
  </div>
  <!-- ⬆⬆ -->
</section>

      {{-- Header --}}
      <header class="header header--black" role="banner">
  <div class="container">
    <div class="row middle-xs">
      <div class="col-md-2 col-xs-6">
        <a class="scroll logo" href="#wrapper" aria-label="Kembali ke atas"><h2 class="m-0">FM</h2></a>
      </div>

      {{-- Tombol hamburger --}}
      <div class="col-md-10 col-xs-6 text-right">
      <nav class="main-nav" role="navigation" aria-label="Navigasi utama">
            <button type="button" class="mobile-but"
                aria-label="Buka menu"
                aria-expanded="false"
                aria-controls="mainMenu">
                <span class="lines" aria-hidden="true"></span>
            </button>

          <!-- Menu -->
          <ul id="mainMenu" class="nav-list">
            <li><a class="scroll" href="#wrapper">Home</a></li>
            <li><a class="scroll" href="#about">About</a></li>
            <li><a class="scroll" href="#schedule">Schedule</a></li>
            <li><a class="scroll" href="#faq">FAQ</a></li>

            @if (Route::has('login'))
              <li class="nav-auth">
                @auth
                  <div class="nav-auth-group">
                    <a href="{{ url('/dashboard') }}" class="btn-auth btn-ghost">Dashboard</a>
                  </div>
                @else
                  <div class="nav-auth-group">
                    <a href="{{ route('login') }}" class="btn-auth btn-ghost">Login</a>
                    @if (Route::has('register'))
                      <a href="{{ route('register') }}" class="btn-auth btn-primary">Register</a>
                    @endif
                  </div>
                @endauth
              </li>
            @endif
          </ul>
          {{-- Backdrop untuk menutup drawer --}}
        <div class="nav-backdrop" hidden></div>
        </nav>
        </nav>
      </div>
    </div>
  </div>
</header>

    {{-- About --}}
    <section id="about" class="about pt-120 pb-120 brd-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 mb-100 text-center">
            <h1 class="title">Festival Mahasiswa Universitas Indraprasta PGRI 2025</h1>
            <p class="title-lead mt-20">
              Festival ini adalah perayaan terbesar di lingkungan kampus, tempat seluruh mahasiswa berkumpul untuk menunjukkan kreativitas, bakat, serta semangat kebersamaan. Acara ini menghadirkan konser musik, pentas seni, bazar, hingga kompetisi seru yang semuanya digelar oleh dan untuk mahasiswa. Lebih dari sekadar hiburan, festival ini menjadi wadah untuk mempererat solidaritas, menghidupkan budaya kampus, serta memberi ruang bagi mahasiswa untuk berekspresi dan menginspirasi.
            </p>
          </div>
        </div>
      </div>

    {{-- Schedule --}}
    <section id="schedule" class="schedule pt-120 pb-120">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 mb-100 text-center">
            <h1 class="title">Festival Schedule</h1>
            <p class="title-lead mt-10">Berikut adalah rundown resmi Festival Mahasiswa<br>yang berisi rangkaian kegiatan dari awal hingga akhir acara.</p>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row"><div class="col-sm-12"><h3 class="sub-title-0 mb-25"><span class="gradient-text">Festival Day</span></h3></div></div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-4">
            <ul class="block-tabs">
              <li class="active"><i class="et-line-calendar"></i><strong>Day 1</strong> <span>- 28 September 2025</span></li>
              <li><i class="et-line-calendar"></i><strong>Day 2</strong> <span>- 29 September 2025</span></li>
              <li><i class="et-line-calendar"></i><strong>Day 3</strong> <span>- 30 September 2025</span></li>
            </ul>
          </div>

          <div class="col-sm-8">
            <ul class="block-tab">
              {{-- Day 1 --}}
              <li class="active">
                <div class="block-date"><i class="et-line-calendar"></i><strong>Day 1</strong> <span>- 28 September 2025</span></div>

                <div class="block-detail">
                  <span class="time">08:00 - 10:00</span>
                  <span class="topic">Opening Ceremony</span>
                  <div class="block-text">
                    <p>Pembukaan resmi festival dengan sambutan dan penampilan pembuka.</p>
                    <span class="speaker"><strong>MC</strong> : <a href="#" class="gradient-text">Panitia Festival</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">10:30 - 12:30</span>
                  <span class="topic">Pentas Seni Mahasiswa</span>
                  <div class="block-text">
                    <p>Kolaborasi tari, band akustik, dan teater kampus.</p>
                    <span class="speaker"><strong>Performer</strong> : <a href="#" class="gradient-text">UKM Seni</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">13:00</span>
                  <span class="topic">Lunch Break</span>
                </div>

                <div class="block-detail">
                  <span class="time">15:00 - 16:30</span>
                  <span class="topic">Kompetisi Band</span>
                  <div class="block-text">
                    <p>Babak penyisihan kompetisi band antarfakultas.</p>
                    <span class="speaker"><strong>Juri</strong> : <a href="#" class="gradient-text">Dosen & Praktisi</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">17:00</span>
                  <span class="topic">Coffee Break</span>
                </div>

                <div class="block-detail">
                  <span class="time">17:30 - 18:00</span>
                  <span class="topic">Pengumuman Harian</span>
                  <div class="block-text">
                    <p>Rangkuman kegiatan dan informasi untuk hari berikutnya.</p>
                    <span class="speaker"><strong>Host</strong> : <a href="#" class="gradient-text">Panitia</a></span>
                  </div>
                </div>
              </li>

              {{-- Day 2 --}}
              <li>
                <div class="block-date"><i class="et-line-calendar"></i><strong>Day 2</strong> <span>- 29 September 2025</span></div>

                <div class="block-detail">
                  <span class="time">08:00 - 10:00</span>
                  <span class="topic">Workshop Kreatif</span>
                  <div class="block-text">
                    <p>Konten kreatif, fotografi, dan desain poster event kampus.</p>
                    <span class="speaker"><strong>Pemateri</strong> : <a href="#" class="gradient-text">Komunitas Kreatif</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">10:30 - 12:30</span>
                  <span class="topic">Talkshow Karier</span>
                  <div class="block-text">
                    <p>Berbagi pengalaman alumni dan tips internship.</p>
                    <span class="speaker"><strong>Alumni</strong> : <a href="#" class="gradient-text">Unindra</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">13:00</span>
                  <span class="topic">Lunch Break</span>
                </div>

                <div class="block-detail">
                  <span class="time">15:00 - 16:30</span>
                  <span class="topic">Final Kompetisi Band</span>
                  <div class="block-text">
                    <p>Penentuan juara dan penampilan spesial.</p>
                    <span class="speaker"><strong>Juri</strong> : <a href="#" class="gradient-text">Dosen & Praktisi</a></span>
                  </div>
                </div>

                <div class="block-detail">
                  <span class="time">17:00</span>
                  <span class="topic">Coffee Break</span>
                </div>

                <div class="block-detail">
                  <span class="time">17:30 - 18:00</span>
                  <span class="topic">Pengumuman Harian</span>
                </div>
              </li>

              {{-- Day 3 --}}
              <li>
                <div class="block-date"><i class="et-line-calendar"></i><strong>Day 3</strong> <span>- 30 September 2025</span></div>

                <div class="block-detail">
                  <span class="time">08:00 - 10:00</span>
                  <span class="topic">Pameran & Bazar</span>
                </div>

                <div class="block-detail">
                  <span class="time">10:30 - 12:00</span>
                  <span class="topic">Awarding</span>
                </div>

                <div class="block-detail">
                  <span class="time">15:00 - 17:00</span>
                  <span class="topic">Konser Puncak</span>
                </div>

                <div class="block-detail">
                  <span class="time">17:30 - 18:00</span>
                  <span class="topic">Closing Event</span>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </section>

    {{-- Counter --}}
    <section class="counter pt-120 pb-120 overlay parallax">
      <div class="background-img"><img src="{{ asset('img/6.jpg') }}" alt="Countdown Festival" loading="lazy"></div>
      <div class="container">
        <div class="row">
          <div class="col-sm-12 text-center front-p">
            <h1 class="title">Time left until the festival start</h1>
            <p class="title-lead mt-10 mb-20">28 September 2025 — Jakarta, Kampus B</p>
            <span class="countdown gradient-text"></span>
          </div>
        </div>
      </div>
    </section>

    {{-- Sponsor --}}
    <section class="sponser pt-100 pb-100">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 mb-50 text-center">
            <h1 class="title">Bigup to Our Sponsors</h1>
            <p class="title-lead mt-10 mb-20">For further info about sponsoring feel free to get in touch with us</p>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-sm-push-2 text-center">
            <div class="col-md-2 col-sm-2"><div class="block-sponsor"><img src="{{ asset('img/logo/3.png') }}" alt="Sponsor 3" loading="lazy"></div></div>
            <div class="col-md-2 col-sm-2"><div class="block-sponsor"><img src="{{ asset('img/logo/1.png') }}" alt="Sponsor 1" loading="lazy"></div></div>
            <div class="col-md-2 col-sm-2"><div class="block-sponsor"><img src="{{ asset('img/logo/4.png') }}" alt="Sponsor 4" loading="lazy"></div></div>
            <div class="col-md-2 col-sm-2"><div class="block-sponsor"><img src="{{ asset('img/logo/2.png') }}" alt="Sponsor 2" loading="lazy"></div></div>
          </div>
        </div>
      </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="faq pt-120 pb-120 brd-bottom">
      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 mb-100 text-center">
            <h1 class="title">Frequently asked questions</h1>
            <p class="title-lead mt-10 mb-20">Some frequently asked questions for you.</p>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2">
            <div class="block-faq mb-50">
              <h4 class="mb-10">Apakah acara ini untuk umum?</h4>
              <p>Fokus acara adalah mahasiswa di lingkungan kampus. Tamu eksternal mengikuti ketentuan panitia.</p>
            </div>
            <div class="block-faq mb-50">
              <h4 class="mb-10">Bagaimana cara membeli tiket konser?</h4>
              <p>Tiket tersedia di loket kampus dan penjualan online (link akan diumumkan di sosial media resmi).</p>
            </div>
            <div class="block-faq mb-50">
              <h4 class="mb-10">Apakah tersedia stand bazar?</h4>
              <p>Ada. Pendaftaran bazar dikelola oleh panitia ormawa. Slot terbatas, first come first served.</p>
            </div>
          </div>
        </div>
      </div>

      <div class="container">
        <div class="row">
          <div class="col-sm-8 col-sm-offset-2 text-center mt-50">
            <h2 class="sub-title-1">Didn’t find what you are looking for?</h2>
            <p><a class="gradient-text" href="mailto:contact@events.com">contact@events.com</a></p>
          </div>
        </div>
      </div>
    </section>

    {{-- Footer --}}
    <footer class="pt-20 bg-dark">
      <section class="top-footer pb-120">
        <div class="container">
          <div class="row">
            <div class="col-sm-4 col-sm-offset-2">
              <h2 class="sub-title-3 mb-30">About</h2>
              <p>Festival Mahasiswa diselenggarakan oleh dan untuk mahasiswa. Mari merayakan kreativitas, kolaborasi, dan kebersamaan.</p>
              <ul class="block-social mt-20">
                <li><a href="#"><i class="icon-facebook"></i></a></li>
                <li><a href="#"><i class="icon-twitter"></i></a></li>
                <li><a href="#"><i class="icon-youtube"></i></a></li>
                <li><a href="#"><i class="icon-gplus"></i></a></li>
                <li><a href="#"><i class="icon-instagram-1"></i></a></li>
              </ul>
            </div>
            <div class="col-sm-4"></div>
          </div>
        </div>
      </section>

      <div class="bottom-footer bg-black pt-50 pb-50">
        <div class="container">
          <div class="row">
            <div class="col-md-6">
              <p>&copy; 2025 All rights reserved — Festival Mahasiswa.</p>
            </div>
            <div class="col-md-6">
              <ul class="block-legal">
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">About</a></li>
                <li><a href="#">Legal</a></li>
                <li><span><a class="gradient-text scroll" href="#wrapper">Back To Top</a></span></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </footer>
  </div> {{-- End wrapper --}}

  {{-- JS (letakkan file2 ini di public/js) --}}
  <script src="{{ asset('js/jquery-1.12.4.min.js') }}"></script>
  <script src="{{ asset('js/jquery.flexslider-min.js') }}"></script>
  <script src="{{ asset('js/jquery.countdown.min.js') }}"></script>
  <script src="{{ asset('js/smooth-scroll.js') }}"></script>
  <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
  <script src="{{ asset('js/placeholders.min.js') }}"></script>
  <script src="{{ asset('js/venobox.min.js') }}"></script>
  <script src="{{ asset('js/instafeed.min.js') }}"></script>
  <script src="{{ asset('js/script.js') }}"></script>

  {{-- Optional: inisialisasi ringan bila script.js belum ada --}}
  <script>
    // Smooth scroll
    if (typeof SmoothScroll !== 'undefined') { new SmoothScroll('a.scroll[href*="#"]', { speed: 600 }); }

    // Venobox
    if (typeof $ !== 'undefined' && typeof $.fn.venobox === 'function') { $('.venobox').venobox(); }

    // Flexslider (jika dibutuhkan untuk .main-slider .slides)
    if (typeof $ !== 'undefined' && typeof $.fn.flexslider === 'function') {
      $('.main-slider').flexslider({ animation: 'fade', controlNav: true, directionNav: false, slideshowSpeed: 4000 });
    }

    // Countdown (ganti selector .countdown)
    if (typeof $ !== 'undefined' && typeof $.fn.countdown === 'function') {
      $('.countdown').countdown('2025/09/28', function (event) { $(this).text(event.strftime('%Dd %Hh %Mm %Ss')); });
    }
  </script>
</body>
</html>
