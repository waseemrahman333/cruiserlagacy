/**
 * @file
 * Vehicles search: choosing a suggestion submits the filter form (AJAX).
 */
(function (Drupal, once, $) {
  Drupal.behaviors.cruiserVehicleSearch = {
    attach(context) {
      once('cruiser-vehicle-search', 'form.vehicles-filters input[name="search"]', context).forEach((input) => {
        $(input).on('autocompleteselect', (event, ui) => {
          input.value = ui.item.value;
          const submit = input.form.querySelector('[type="submit"]');
          if (submit) {
            // Let autocomplete finish updating the field first.
            setTimeout(() => submit.click(), 0);
          }
        });
      });
    },
  };
})(Drupal, once, jQuery);
