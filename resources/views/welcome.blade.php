<!DOCTYPE html>
<html lang="id">

<head>
    <title>Rockfest - Music Festival Event, DJ Concert and Night Club Website Template</title>
    <link rel="icon" href="images-dj/icon.png" type="image/gif" sizes="16x16">
    <meta content="text/html;charset=utf-8" http-equiv="Content-Type">
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="Festival Mahasiswa" name="description" />
    <meta content="" name="keywords" />
    <meta content="" name="author" />
    <!-- CSS Files
    ================================================== -->
    <link id="bootstrap" href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link id="bootstrap-grid" href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css" />
    <link id="bootstrap-reboot" href="css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css" />
    <link href="css/animate.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.theme.css" rel="stylesheet" type="text/css" />
    <link href="css/owl.transitions.css" rel="stylesheet" type="text/css" />
    <link href="css/magnific-popup.css" rel="stylesheet" type="text/css" />
    <link href="css/jquery.countdown.css" rel="stylesheet" type="text/css" />
    <link id="mdb" href="css/mdb.min.css" rel="stylesheet" type="text/css" />
    <link href="css/style.css" rel="stylesheet" type="text/css" />
    <link href="css/de-dj.css" rel="stylesheet" type="text/css" />
    <!-- color scheme -->
    <link id="colors" href="css/colors/scheme-02.css" rel="stylesheet" type="text/css" />
    <link href="css/coloring.css" rel="stylesheet" type="text/css" />
</head>

<body class="dark-scheme">
    <div id="wrapper">
        <div id="preloader">
            <div class="preloader1"></div>
        </div>
        <!-- header begin -->
        <header class="transparent">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="de-flex sm-pt10">
                            <div class="de-flex-col">
                                <div class="de-flex-col">
                                    <!-- logo begin -->
                                    <div id="logo">
                                        <a href="02_djfest-index.html">
                                            <img alt="" src="images-dj/logomini.png" />
                                        </a>
                                    </div>
                                    <!-- logo close -->
                                </div>
                                <div class="de-flex-col">
                                </div>
                            </div>
                            <div class="de-flex-col header-col-mid">
                                <!-- mainmenu begin -->
                                <ul id="mainmenu">
                                    <li><a href="#">Home</a>
                                    </li>
                                    <li><a href="#section-about">About</a></li>
                                    <li><a href="#section-artists">Artists</a></li>
                                    <li><a href="#section-schedule">Schedule</a></li>
                                </ul>
                            </div>
                            <div class="de-flex-col">
                                <div class="menu_side_area">
                                    <a href="{{ route('login')}}" class="btn-main"><i class="fa fa-sign-in"></i><span>Login</span></a>
                                    <span id="menu-btn"></span>
                                    <a href="{{ route('register')}}" class="btn-main"><i class="fa fa-sign-in"></i><span>Register</span></a>
                                    <span id="menu-btn"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- header close -->
        <!-- content begin -->
        <div class="no-bottom no-top" id="content">
            <div id="top"></div>
            <!-- Carousel wrapper -->
            <section id="de-carousel" class="no-top no-bottom carousel slide carousel-fade shadow-2-strong" data-mdb-ride="carousel">
                <!-- Indicators -->
                </ol>
                <!-- Inner -->
                <div class="carousel-inner">
                    <!-- Single item -->
                    <div class="carousel-item active" data-bgimage="url(images-dj/slider/1.jpg)">
                        <div class="mask">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <div class="container text-white text-center">
                                    <div class="row">
                                        <div class="col-md-1s3">
                                            <h1 class="ultra-big mb-3 wow fadeInUp"><br><span class="id-color"></span></h1>
                                            <div class="col-md-7 offset-md-3">
                                                <p class="lead wow fadeInUp" data-wow-delay=".3s"></p>
                                            </div>
                                             <div class="spacer-10"></div>
                                             @if (Route::has ('register'))
                                             <a href="{{ route('register')}}" class="btn-main wow fadeInUp" data-wow-delay=".6s">CLAIM TIKET HERE!</a>
                                             @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- Inner -->
                <!-- Ga kepake -->
                <a class="carousel-control-prev" href="#de-carousel" role="button" data-mdb-slide="prev">
                </a>
                </a>
            </section>
            <!-- Carousel wrapper -->

            <div class="arrow_wrap">
                <div class="arrow__up"></div>
            </div>
            <section id="section-date" class="bg-color pt40 pb30">
                <div class="container">
                    <div class="row g-custom-x align-items-center">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <h2 class="s2 text-black wow fadeInUp" data-wow-delay="0s">28 Sept 2025</h2>
                                <h3 class="text-black wow fadeInUp" data-wow-delay=".2s">Parkiran Kampus B,</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!--Section About-->
            <section id="section-about" class="bg-light py-12" data-bgimage="url(images-dj/background/About.png)">
                <div class="container">
                    <div class="row g-custom-x align-items-center">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="wm wow slideInUp" style="font-family: 'Orbitron', sans-serif; font-size: 3rem; font-weight: bold; color: #333;"></div>
                                <h2 class="wow fadeInUp" data-wow-delay=".2s" style="font-family: 'Orbitron', sans-serif; font-size: 3.5rem; color: #333;">
                                    <span class="id-color">01</span> <span class="font-bold">Festival Mahasiswa</span>
                                </h2>
                                <div class="small-border bg-color-2 mx-auto"></div>
                                <div class="spacer-single"></div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <p class="text-lg text-dark font-bold" style="font-family: 'montserrat', montserrat; font-size: 1.25rem; line-height: 1.8; color: #333;">
                                Festival Mahasiswa adalah acara tahunan yang bertujuan untuk menyatukan mahasiswa dari berbagai universitas.
                                Dengan berbagai kegiatan seperti konser musik, talk show, dan lomba kreatif, Festival Mahasiswa bertujuan
                                untuk mempererat hubungan antar mahasiswa sekaligus memperkenalkan inovasi dan kreativitas mereka kepada masyarakat.
                            </p>
                            <p class="mt-4 text-lg text-dark font-bold" style="font-family: 'montserrat', montserrat; font-size: 1.25rem; line-height: 1.8; color: #333;">
                                Festival ini diadakan untuk memberikan platform bagi mahasiswa untuk mengekspresikan diri, berbagi pengetahuan,
                                serta merayakan keberagaman budaya dan ideologi dalam dunia pendidikan.
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <!--Section Artist-->
            <section id="section-artists">
                <div class="container">
                    <div class="row g-custom-x align-items-center">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="wm wow slideInUp">Artists</div>
                                <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">01</span> Artists</h2>
                                <div class="small-border bg-color-2"></div>
                                <div class="spacer-single"></div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-30">
                            <div class="de-image-text s2 wow flipInY">
                                <a href="#" class="d-text">
                                    <div class="arrow_wrap">
                                        <div class="arrow__up"></div>
                                    </div>
                                    <h3>-</h3>
                                </a>
                                <img src="images-dj/misc/featured-1.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-30">
                            <div class="de-image-text s2 wow flipInY">
                                <a href="#" class="d-text">
                                    <div class="arrow_wrap">
                                        <div class="arrow__up"></div>
                                    </div>
                                    <h3>-</h3>
                                </a>
                                <img src="images-dj/misc/featured-2.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-md-4 mb-sm-30">
                            <div class="de-image-text s2 wow flipInY">
                                <a href="#" class="d-text">
                                    <div class="arrow_wrap">
                                        <div class="arrow__up"></div>
                                    </div>
                                    <h3>-</h3>
                                </a>
                                <img src="images-dj/misc/featured-3.jpg" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10 offset-md-1 text-center">
                            <div class="spacer-single"></div>
                            <ul class="list-inline-style-1">
                                <li>Albetad</li>
                                <li>Formulary</li>
                                <li>Stylewort</li>
                                <li>Windgalled</li>
                                <li>Taxidermize</li>
                                <li>Lysimachus</li>
                                <li>Cassinese</li>
                                <li>Abiezer</li>
                                <li>Chevelle</li>
                                <li>Carabus</li>
                                <li>Aggrieved</li>
                                <li>Floater</li>
                                <li>Ovidae</li>
                                <li>Rockward</li>
                                <li>Hotbox</li>
                                <li>Emarcid</li>
                                <li>Victuallership</li>
                                <li>Barnard</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </section>
            <section id="section-schedule" aria-label="section-services-tab" data-bgimage="url(images-dj/background/Rundown.jpg)">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="text-center">
                                <div class="wm wow slideInUp">Schedule</div>
                                <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">02</span> Schedule</h2>
                                <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                            </div>
                        </div>
                        <div class="spacer-single"></div>
                        <div class="col-md-12">
                            <div class="de_tab tab_style_4 text-center">
                                <ul class="de_nav de_nav_dark">
                                    <li data-link="#section-services-tab">
                                        <h3>Day <span>01</span></h3>
                                        <h4>Sept 28, 2025</h4>
                                    </li>
                                    <li data-link="#section-services-tab">
                                        <h3>Day <span>02</span></h3>
                                        <h4>Sept 28, 2025</h4>
                                    </li>
                                </ul>
                                <div class="de_tab_content text-left">
                                    <div id="tab1" class="tab_single_content">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <ul class="list-boxed-s1">
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div id="tab2" class="tab_single_content">
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <ul class="list-boxed-s1">
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                    <li>
                                                        <h3>-</h3><span></span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section style="background-color: #2EA9E0;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="wm wow slideInUp">Sponsors</div>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">05</span> Sponsored by:</h2>
                            <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        </div>
                        <div class="spacer-single"></div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30 justify-content-center">
                            <img src="images/sponsors/BurgerKing-01.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </section>


            <section style="background-color: #2EA9E0;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="wm wow slideInUp">MediaPartner</div>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">06</span> MediaPartner by:</h2>
                            <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        </div>
                        <div class="spacer-single"></div>
                    </div>
                    <div class="row g-custom-x">
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/AfterFive-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/BekasiGigs-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/FomoEvent-01.PNG" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/GAC-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/HOBBYKONSERSOLO-01.PNG" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/InfoMusikKita-01.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </section>

            <section style="background-color: #2EA9E0;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                    </div>
                    <div class="row g-custom-x">
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/JakartaMusikFest-01.PNG" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/JurnalKonser-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/Kemenses21-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/KonserMyMusik-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/KonserRaya-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/KonseranBestie-01.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </section>

            <section style="background-color: #2EA9E0;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                        </div>
                    </div>
                    <div class="row g-custom-x">
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/LPMProgress-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/MASANETWORK-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/Sindikart-01.png" class="img-fluid" alt="">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30">
                            <img src="images/mediapartner/SupportKonser-01.png" class="img-fluid" alt="">
                        </div>
                    </div>
                </div>
            </section>

            <section style="background-color: #2EA9E0;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div class="wm wow slideInUp">Partnership</div>
                            <h2 class="wow fadeInUp" data-wow-delay=".2s"><span class="id-color">07</span> Partnership by:</h2>
                            <div class="small-border bg-color wow zoomIn" data-wow-delay=".4s"></div>
                        </div>
                        <div class="spacer-single"></div>
                    </div>
                    <div class="row justify-content-center"> <!-- Added justify-content-center to center the logos -->
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30 d-flex justify-content-center"> <!-- Added d-flex and justify-content-center to center logo -->
                            <img src="images/partnership/Logo Dobrak P-01.png" class="img-fluid" alt="logo1">
                        </div>
                        <div class="col-lg-2 col-md-4 col-6 mb-sm-30 d-flex justify-content-center"> <!-- Same as above for other logo -->
                            <img src="images/partnership/Mangele Logo-01.png" class="img-fluid" alt="logo1">
                        </div>
                    </div>
                </div>
            </section>

            <section id="section-countdown" aria-label="section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-10 offset-md-1">
                            <div class="wm wow slideInUp">Begins</div>
                            <div id="defaultCountdown" class="wow fadeInUp" data-wow-delay=".2s"></div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- content close -->
        <a href="#" id="back-to-top"></a>
        <!-- footer begin -->
        <footer data-bgimage="url()">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-1">
                        <div class="widget">
                            <h5>Contact Info</h5>
                            <address class="s1">
                                <span><i class="id-color fa fa-map-marker fa-lg"></i>Kampung Tengah Gedong, Jakarta Timur, Unindra</span>
                                <span><i class="id-color fa fa-phone fa-lg"></i>+62 no humas</span>
                                <span><i class="id-color fa fa-envelope-o fa-lg"></i><a href="mailto:contact@example.com">contact@example.com</a></span>
                            </address>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-1">
                        <div class="widget">
                            <h5>Quick Links</h5>
                            <ul>
                                <li><a href="02_djfest-contact.html">Contact Us</a></li>
                                <li><a href="#section-tickets">Ticket</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-1">
                        <div class="widget">
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-1">
                        <div class="widget">
                            <h5>Newsletter</h5>
                            <p>Signup for our newsletter to get the latest news in your inbox.</p>
                            <form action="blank.php" class="row form-dark" id="form_subscribe" method="post" name="form_subscribe">
                                <div class="col text-center">
                                    <input class="form-control" id="txt_subscribe" name="txt_subscribe" placeholder="enter your email" type="text" /> <a href="#" id="btn-subscribe"><i class="arrow_right bg-color-secondary"></i></a>
                                    <div class="clearfix"></div>
                                </div>
                            </form>
                            <div class="spacer-10"></div>
                            <small>Your email is safe with us. We don't spam.</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="subfooter">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="de-flex">
                                <div class="de-flex-col">
                                    <a href="02_djfest-index.html">
                                        <img alt="" class="f-logo" src="images-dj/logomini.png" /><span class="copy">&copy; Copyright 2025 - Ruang Teknologi</span>
                                    </a>
                                </div>
                                <div class="de-flex-col">
                                    <div class="social-icons">
                                        <a href="#"><i class="fa fa-facebook fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-twitter fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-linkedin fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-pinterest fa-lg"></i></a>
                                        <a href="#"><i class="fa fa-rss fa-lg"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- footer close -->
    </div>

    <!-- Javascript Files
    ================================================== -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/wow.min.js"></script>
    <script src="js/jquery.isotope.min.js"></script>
    <script src="js/easing.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="js/jquery.magnific-popup.min.js"></script>
    <script src="js/enquire.min.js"></script>
    <script src="js/jquery.plugin.js"></script>
    <script src="js/jquery.countTo.js"></script>
    <script src="js/jquery.countdown.js"></script>
    <script src="js/jquery.lazy.min.js"></script>
    <script src="js/jquery.lazy.plugins.min.js"></script>
    <script src="js/mdb.min.js"></script>
    <script src="js/jquery.countdown.js"></script>
    <script src="js/countdown-custom.js"></script>
    <script src="js/cookit.js"></script>
    <script src="js/designesia.js"></script>

<!-- COOKIES PLUGIN  -->
     <script>
      $(document).ready(function() {
        $.cookit({
          backgroundColor: '#cdff6b',
          messageColor: '#000000',
          linkColor: '#000000',
          buttonColor: '#000000',
          messageText: "This website uses cookies to ensure you get the best experience on our website.",
          linkText: "Learn more",
          linkUrl: "02_djfest-index.html",
          buttonText: "I accept",
        });
      });
    </script>
</body>

</html>