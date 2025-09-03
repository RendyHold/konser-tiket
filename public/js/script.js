(function ($) {
    "use strict";

    // Window load
    $(window).on("load", function () {
      // Site loader
      $(".loader-inner").fadeOut();
      $(".loader").delay(200).fadeOut("slow");

      // Init Google Map kalau ada elemen & API sudah dimuat
      if (document.getElementById("map") && window.google && google.maps) {
        initializeMap();
      }
    });

    // Smooth scroll (aman jika lib-nya ada)
    if ($.fn.smoothScroll) {
      $("a.scroll").smoothScroll({ speed: 800, offset: -50 });
    }

    // Sliders (aman jika flexslider ada)
    if ($.fn.flexslider) {
      if ($(".slider").length) {
        $(".slider").flexslider({
          animation: "fade",
          slideshow: true,
          directionNav: true,
          controlNav: false,
          pauseOnAction: false,
          animationSpeed: 500
        });
      }
      if ($(".review-slider").length) {
        $(".review-slider").flexslider({
          animation: "fade",
          slideshow: true,
          directionNav: false,
          controlNav: true,
          pauseOnAction: false,
          animationSpeed: 1000
        });
      }
    }

    // ===== Mobile menu (kompatibel header baru & lama) =====
    (function ($) {
        "use strict";

        const $nav  = $('.main-nav');
        const $btn  = $nav.find('.mobile-but');
        const $list = $('#mainMenu');
        const $backdrop = $nav.find('.nav-backdrop');

        function closeNav(){
          $nav.removeClass('is-open');
          $btn.attr('aria-expanded','false');
        }

        $btn.on('click', function (e) {
          e.preventDefault();
          const open = $nav.toggleClass('is-open').hasClass('is-open');
          $btn.attr('aria-expanded', open ? 'true' : 'false');
        });

        // klik backdrop menutup menu
        $backdrop.on('click', closeNav);

        // pilih item menu (mobile) => tutup
        $list.on('click', 'a', function () {
          if (window.matchMedia('(max-width: 767.98px)').matches) closeNav();
        });

        // === Background image fallback (kalau img tidak “terbaca”) ===
        $('.background-img').each(function(){
          var path = $(this).children('img').attr('src') || $(this).data('bg') || '';
          if (path) {
            $(this)
              .css('background-image', 'url("' + path + '")')
              .css('background-position', 'center');
          }
        });

      })(jQuery);

    // ===== Countdown -> 28 Sept 2025 =====
    if ($.fn.countdown && $(".countdown").length) {
      $(".countdown").countdown("2025/09/28 00:00:00", function (event) {
        $(this).html(event.strftime("%Dd %Hh %Mm %Ss"));
      });
    }

    // Tabbed content
    $(".block-tabs").on("click", "li", function () {
      if (!$(this).hasClass("active")) {
        var idx = $(this).index() + 1;
        $(this).addClass("active").siblings().removeClass("active");
        $(".block-tab li").removeClass("active");
        $(".block-tab li:nth-child(" + idx + ")").addClass("active");
      }
    });

    // Hover zoom effects
    $(".gallery").on("mouseenter", ".block-gallery li", function () {
      $(this).addClass("active").siblings().removeClass("active");
    });

    $(".tickets").on("mouseenter", ".block-ticket", function () {
      $(this).addClass("active").siblings().removeClass("active");
    });

    // Venobox (lightbox)
    if ($.fn.venobox) {
      $(".venobox").venobox({
        titleattr: "data-title",
        numeratio: true
      });
    }

    // Instagram feed (opsional; guard agar tidak error)
    if (window.Instafeed && $("#instafeed").length) {
      try {
        var instaFeed = new Instafeed({
          target: "instafeed",
          get: "user",
          userId: "305801553",
          accessToken: "305801553.1677ed0.3d872300c10c4ff687868875ee8abc5d",
          limit: 6,
          template: '<li class="col-sm-4"><a href="{{link}}"><img src="{{image}}" alt="Instagram"></a></li>'
        });
        instaFeed.run();
      } catch (e) {
        console.warn("Instafeed init skipped:", e.message);
      }
    }

    // Form validation (fix duplicate rules)
    if ($.fn.validate && $(".registry-form").length) {
      $(".registry-form").validate({
        validClass: "valid",
        errorClass: "error",
        errorPlacement: function () { return true; },
        onfocusout: function (element) { $(element).valid(); },
        rules: {
          email: { required: true, email: true },
          name:  { required: true, minlength: 3 }
        }
      });
    }
  })(jQuery);

  // ========== Google Map Setup ==========
  function initializeMap() {
    var styles = [
        {"elementType":"geometry","stylers":[{"color":"#212121"}]},
        {"elementType":"labels.icon","stylers":[{"visibility":"off"}]},
        {"elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},
        {"elementType":"labels.text.stroke","stylers":[{"color":"#212121"}]},
        {"featureType":"administrative","elementType":"geometry","stylers":[{"color":"#757575"}]},
        {"featureType":"administrative.country","elementType":"labels.text.fill","stylers":[{"color":"#9e9e9e"}]},
        {"featureType":"administrative.land_parcel","stylers":[{"visibility":"off"}]},
        {"featureType":"administrative.locality","elementType":"labels.text.fill","stylers":[{"color":"#bdbdbd"}]},
        {"featureType":"poi","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},
        {"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#181818"}]},
        {"featureType":"poi.park","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},
        {"featureType":"poi.park","elementType":"labels.text.stroke","stylers":[{"color":"#1b1b1b"}]},
        {"featureType":"road","elementType":"geometry.fill","stylers":[{"color":"#2c2c2c"}]},
        {"featureType":"road","elementType":"labels.text.fill","stylers":[{"color":"#8a8a8a"}]},
        {"featureType":"road.arterial","elementType":"geometry","stylers":[{"color":"#373737"}]},
        {"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#3c3c3c"}]},
        {"featureType":"road.highway.controlled_access","elementType":"geometry","stylers":[{"color":"#4e4e4e"}]},
        {"featureType":"road.local","elementType":"labels.text.fill","stylers":[{"color":"#616161"}]},
        {"featureType":"transit","elementType":"labels.text.fill","stylers":[{"color":"#757575"}]},
        {"featureType":"water","elementType":"geometry","stylers":[{"color":"#000000"}]},
        {"featureType":"water","elementType":"labels.text.fill","stylers":[{"color":"#3d3d3d"}]}
      ],
      lat = 39.148352,
      lng = -84.443999,
      customMap = new google.maps.StyledMapType(styles, { name: "Styled Map" }),
      mapOptions = {
        zoom: 14,
        scrollwheel: false,
        disableDefaultUI: true,
        draggable: true,
        center: new google.maps.LatLng(lat, lng),
        mapTypeControlOptions: { mapTypeIds: [google.maps.MapTypeId.ROADMAP] }
      },
      map = new google.maps.Map(document.getElementById("map"), mapOptions),
      myLatlng = new google.maps.LatLng(lat, lng),
      marker = new google.maps.Marker({
        position: myLatlng,
        map: map,
        icon: { url: "img/marker.png", scaledSize: new google.maps.Size(80, 80) }
      });

    map.mapTypes.set("map_style", customMap);
    map.setMapTypeId("map_style");

    var transitLayer = new google.maps.TransitLayer();
    transitLayer.setMap(map);
  }
