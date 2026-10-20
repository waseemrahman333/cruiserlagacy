/**
 * @file
 * Alpine.js data component for the Stats Row canvas component.
 *
 * Registers the 'statsRow' Alpine.data component. Parses each stat's raw
 * number string, then animates it from 0 to its target using
 * requestAnimationFrame with an easeOutQuart curve. The animation is
 * triggered once via IntersectionObserver when the section enters the
 * viewport.
 */

document.addEventListener('alpine:init', function () {
  Alpine.data('statsRow', function (config) {
    return {
      duration: config.duration || 2000,
      displayed: [],
      _observed: false,

      init: function () {
        var self = this;
        var items = self.$el.querySelectorAll('[data-stat-number]');
        var raw = [];

        items.forEach(function (el) {
          raw.push(el.dataset.statNumber);
        });

        self.displayed = raw.slice();

        var observer = new IntersectionObserver(
          function (entries) {
            entries.forEach(function (entry) {
              if (entry.isIntersecting && !self._observed) {
                self._observed = true;
                self._animateAll(raw);
                observer.disconnect();
              }
            });
          },
          { threshold: 0.2 }
        );

        observer.observe(self.$el);
      },

      /**
       * Animate all stats simultaneously.
       *
       * @param {Array.<string>} rawValues - Array of raw stat strings.
       */
      _animateAll: function (rawValues) {
        var self = this;
        rawValues.forEach(function (raw, index) {
          var parsed = self._parse(raw);
          self._countUp(index, parsed.value, parsed.prefix, parsed.suffix);
        });
      },

      /**
       * Parse a stat string into numeric value, prefix, and suffix.
       *
       * @param {string} raw - Raw stat string (e.g. '10,000+', '99%').
       * @return {{ value: number, prefix: string, suffix: string }}
       */
      _parse: function (raw) {
        var cleaned = raw.replace(/,/g, '');
        var match = cleaned.match(/^([^0-9]*)([0-9]+(?:\.[0-9]+)?)([^0-9]*)$/);
        if (!match) {
          return { value: 0, prefix: '', suffix: raw };
        }
        return {
          prefix: match[1],
          value: parseFloat(match[2]),
          suffix: match[3],
        };
      },

      /**
       * Animate a single stat from 0 to target using easeOutQuart.
       *
       * @param {number} index  - Index into this.displayed[].
       * @param {number} target - Numeric target value.
       * @param {string} prefix - Non-numeric prefix (e.g. '~').
       * @param {string} suffix - Non-numeric suffix (e.g. '+', '%').
       */
      _countUp: function (index, target, prefix, suffix) {
        var self = this;
        var startTime = null;
        var duration = self.duration;
        var isInteger = Number.isInteger(target);

        function step(timestamp) {
          if (!startTime) {
            startTime = timestamp;
          }
          var elapsed = timestamp - startTime;
          var progress = Math.min(elapsed / duration, 1);
          var eased = 1 - Math.pow(1 - progress, 4);
          var current = target * eased;
          var formatted = isInteger
            ? Math.round(current).toLocaleString()
            : current.toFixed(1);

          self.displayed[index] = prefix + formatted + suffix;

          if (progress < 1) {
            requestAnimationFrame(step);
          }
          else {
            self.displayed[index] = prefix + (isInteger ? target.toLocaleString() : target.toFixed(1)) + suffix;
          }
        }

        requestAnimationFrame(step);
      },
    };
  });
});
