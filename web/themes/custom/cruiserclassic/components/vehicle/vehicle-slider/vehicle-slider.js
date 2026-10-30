/**
 * @file
 * Vehicle Slider: Slick on .vehicle-slider__track with custom arrows.
 */
(function ($, Drupal, once) {
  Drupal.behaviors.cruiserVehicleSlider = {
    attach(context) {
      once('vehicle-slider', '[data-vehicle-slider]', context).forEach((el) => {
        const $track = $(el).find('.vehicle-slider__track');
        if ($track.children().length < 2 || typeof $.fn.slick !== 'function') {
          return;
        }
        const prev = el.querySelector('[data-slider-prev]');
        const next = el.querySelector('[data-slider-next]');

        $track.on('init afterChange', (event, slick) => {
          const current = slick.currentSlide || 0;
          if (prev) prev.disabled = current === 0;
          if (next) next.disabled = current >= slick.slideCount - 1;
        });

        $track.slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          arrows: false,
          dots: false,
          infinite: false,
          speed: 400,
          adaptiveHeight: false,
          autoplay: el.dataset.autoplay === 'true',
          autoplaySpeed: 5000,
        });

        if (prev) prev.addEventListener('click', () => $track.slick('slickPrev'));
        if (next) next.addEventListener('click', () => $track.slick('slickNext'));
      });
    },
  };
})(jQuery, Drupal, once);
