/**
//  @file
 * Supplementary behavior for the Tailpine Color Theme Switcher block.
 *
 * The primary theme restoration (localStorage → data-theme) happens via a
 * synchronous inline <script> injected into <head> by
 * tailpine_page_attachments_alter(). This behavior exposes a global
 * Drupal.tailpine.setTheme() API for programmatic use by other JS.
 *
 * The Alpine.js component in color-switcher.twig handles all swatch
 * interactivity — this file is intentionally thin.
 */

// ((Drupal) => {

//   'use strict';

//   Drupal.behaviors.tailpineColorThemeSwitcher = {
//     attach: () => {
//       Drupal.tailpine = Drupal.tailpine || {};

//       /**
//        * Programmatically switch the active color theme.
//        *
//        * @param {string} name - Theme machine name (e.g. 'ocean', 'cyberpunk').
//        */
//       Drupal.tailpine.setTheme = (name) => {
//         document.documentElement.setAttribute('data-theme', name);
//         try {
//           localStorage.setItem('tailpine_color_theme', name);
//         }
//         catch (e) {
//           // localStorage may be unavailable in private browsing — fail silently.
//         }
//       };
//     },
//   };

// })(Drupal);

((Drupal, once) => {

  'use strict';

  Drupal.behaviors.tailpineColorThemeSwitcher = {
    attach: (context) => {
      Drupal.tailpine = Drupal.tailpine || {};

      Drupal.tailpine.setTheme = (name) => {
        document.documentElement.setAttribute('data-theme', name);
        try {
          localStorage.setItem('tailpine_color_theme', name);
        }
        catch (e) {
          // localStorage may be unavailable in private browsing — fail silently.
        }
      };

      once('tailpine-switcher-sync', 'html', context).forEach((html) => {
        const switcherPresent = document.querySelector('[data-tailpine-color-switcher]');

        if (!switcherPresent) {
          // Switcher is disabled — reset the stored preference so it can't
          // resurface later, but never touch data-theme here; the server
          // rendered value stays exactly as-is.
          try {
            localStorage.removeItem('tailpine_color_theme');
          }
          catch (e) {}
          return;
        }

        // Switcher is enabled — restore the last picked theme, if any.
        let saved;
        try {
          saved = localStorage.getItem('tailpine_color_theme');
        }
        catch (e) {
          saved = null;
        }

        if (saved) {
          html.setAttribute('data-theme', saved);
        }
      });
    },
  };

})(Drupal, once);