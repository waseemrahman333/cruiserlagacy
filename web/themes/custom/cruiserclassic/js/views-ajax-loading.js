/**
 * @file
 * Views AJAX filters: fade the results instead of core's full-screen throbber.
 *
 * While a /views/ajax request runs, the matching view gets .is-view-loading
 * (see main.css); it is removed when the request finishes.
 */
(function ($) {
  const viewFor = (settings) => {
    const match = /[?&]view_dom_id=([^&]+)/.exec(settings.url || '') || /(?:^|&)view_dom_id=([^&]+)/.exec(settings.data || '');
    return match ? document.querySelector(`.js-view-dom-id-${decodeURIComponent(match[1])}`) : null;
  };
  $(document)
    .on('ajaxSend', (event, xhr, settings) => {
      if ((settings.url || '').includes('/views/ajax')) {
        viewFor(settings)?.classList.add('is-view-loading');
      }
    })
    .on('ajaxComplete', () => {
      document.querySelectorAll('.is-view-loading').forEach((el) => el.classList.remove('is-view-loading'));
    });
})(jQuery);
