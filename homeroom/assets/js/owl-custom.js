(function ($) {
  // USE STRICT
  "use strict";

  $(document).ready(function () {

    var $owlSelector = $('.owl-carousel');

    if ($owlSelector !== undefined) {
      $owlSelector.each(function () {
        var option = {
          autoinit: true,
          items: 3,
          margin: 0,
          loop: false,
          center: false,
          mousedrag: true,
          touchdrag: true,
          pulldrag: true,
          nav: false,
          navtext: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
          dots: false,
          dotsdata: false,
          autoplay: false,
          smartspeed: 650,
          animateout: null,
          animatein: null,
          rtl: false,
          video: false,
          xs: 1,
          sm: 2,
          md: 2,
          lg: 3
        };

        for (var k in option) {
          if (option.hasOwnProperty(k)) {
            if ($(this).attr('data-carousel-' + k) != null) {
              option[k] = $(this).data('carousel-' + k);
            }
          }
        }

        if (option.autoinit) {
          $(this).owlCarousel({
            margin: option.margin,
            loop: option.loop,
            center: option.center,
            mouseDrag: option.mousedrag,
            touchDrag: option.touchdrag,
            pullDrag: option.pulldrag,
            nav: option.nav,
            navText: option.navtext,
            dots: option.dots,
            dotsData: option.dotsdata,
            autoplay: option.autoplay,
            smartSpeed: option.smartspeed,
            animateIn: option.animatein,
            animateOut: option.animateout,
            rtl: option.rtl,
            video: option.video,
            videoHeight: 660,
            responsive: {
              0: {
                items: option.xs
              },
              576: {
                items: option.sm
              },
              768: {
                items: option.md
              },
              992: {
                items: option.lg
              },
              1200: {
                items: option.items
              }
            }
          });
        }
      });
    }
  });

})(jQuery);

function owlCarousel($owlSelector) {
  if ($owlSelector !== undefined) {
    $owlSelector.each(function () {
      var option = {
        items: 3,
        margin: 0,
        loop: false,
        center: false,
        mousedrag: true,
        touchdrag: true,
        pulldrag: true,
        nav: false,
        navtext: ["<i class='fa fa-angle-left'></i>", "<i class='fa fa-angle-right'></i>"],
        dots: false,
        dotsdata: false,
        autoplay: false,
        smartspeed: 650,
        animateout: null,
        animatein: null,
        rtl: false,
        video: false,
        xs: 1,
        sm: 2,
        md: 2,
        lg: 3
      };

      for (var k in option) {
        if (option.hasOwnProperty(k)) {
          if ($(this).attr('data-carousel-' + k) != null) {
            option[k] = $(this).data('carousel-' + k);
          }
        }
      }

      $(this).owlCarousel({
        margin: option.margin,
        loop: option.loop,
        center: option.center,
        mouseDrag: option.mousedrag,
        touchDrag: option.touchdrag,
        pullDrag: option.pulldrag,
        nav: option.nav,
        navText: option.navtext,
        dots: option.dots,
        dotsData: option.dotsdata,
        autoplay: option.autoplay,
        smartSpeed: option.smartspeed,
        animateIn: option.animatein,
        animateOut: option.animateout,
        rtl: option.rtl,
        video: option.video,
        videoHeight: 660,
        responsive: {
          0: {
            items: option.xs
          },
          576: {
            items: option.sm
          },
          768: {
            items: option.md
          },
          992: {
            items: option.lg
          },
          1200: {
            items: option.items
          }
        }
      });

    });
  }
}