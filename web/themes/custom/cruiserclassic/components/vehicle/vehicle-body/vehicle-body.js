/**
 * @file
 * Vehicle Body: built-in print button and click-to-play video.
 */
(function (Drupal, once) {
  Drupal.behaviors.cruiserVehicleBody = {
    attach(context) {
      once('vehicle-print', '[data-vehicle-print]', context).forEach((btn) => {
        btn.addEventListener('click', () => window.print());
      });
      once('vehicle-video', '[data-vehicle-video]', context).forEach((wrap) => {
        const video = wrap.querySelector('video');
        const play = wrap.querySelector('[data-video-play]');
        if (!video || !play) return;
        play.addEventListener('click', () => {
          video.controls = true;
          play.remove();
          video.play();
        });
      });
    },
  };
})(Drupal, once);
