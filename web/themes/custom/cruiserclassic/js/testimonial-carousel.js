(function ($, Drupal) {
  Drupal.behaviors.jeepCarousel = {
    attach(context, settings) {

      $(document).ready(function () {

        var $carousel = $('.responsive-review').slick({
          dots: true,
          infinite: false,
          speed: 300,
          autoplay: true,
          autoplaySpeed: 3000,
          slidesToShow: 2,
          slidesToScroll: 1,

          arrows: false,

          responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 1
              }
            },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1
              }
            }
          ]
        });

        var $prev = $('#carousel-prev');
        var $next = $('#carousel-next');

        $prev.on('click', function () {
          $carousel.slick('slickPrev');
        });

        $next.on('click', function () {
          $carousel.slick('slickNext');
        });

        function syncArrowState(event, slick, currentSlide) {

          var isFirst = currentSlide === 0;

          var isLast =
            currentSlide >=
            slick.slideCount - slick.options.slidesToShow;

          $prev.toggleClass('is-disabled', isFirst);

          $next.toggleClass(
            'is-disabled',
            isLast && !slick.options.infinite
          );
        }

        $carousel.on('init afterChange', function (event, slick, currentSlide) {
          syncArrowState(event, slick, currentSlide || 0);
        });

        syncArrowState(
          null,
          $carousel.slick('getSlick'),
          0
        );

      });

    }
  };
})(jQuery, Drupal);