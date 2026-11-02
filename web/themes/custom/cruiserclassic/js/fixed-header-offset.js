/**
 * @file
 * Logged-in users: push the admin tabs (View / Edit / …) below the fixed header.
 *
 * The header is fixed, so the Highlighted region (local tasks, messages) sits
 * behind it. When logged in, that region gets a top padding equal to the
 * header height, kept in sync when the header resizes. Logged-out visitors
 * see the page unchanged (the header stays over the hero).
 */
(function (Drupal, once) {
  Drupal.behaviors.cruiserclassicAdminTabsOffset = {
    attach(context) {
      if (!document.body.classList.contains('user-logged-in')) {
        return;
      }
      once('admin-tabs-offset', 'body', context).forEach(() => {
        const region = document.querySelector('.region-highlighted');
        // The fixed element is the header or its region wrapper
        // (Tailpine: has-[header.fix]:fixed).
        let header = document.querySelector('.site-header');
        while (header && header !== document.body && getComputedStyle(header).position !== 'fixed') {
          header = header.parentElement;
        }
        if (!region || !header || header === document.body) {
          return;
        }
        const update = () => {
          region.style.paddingTop = `${header.offsetHeight}px`;
        };
        update();
        if ('ResizeObserver' in window) {
          new ResizeObserver(update).observe(header);
        }
        window.addEventListener('load', update);
      });
    },
  };
})(Drupal, once);
