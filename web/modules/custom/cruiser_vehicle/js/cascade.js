/**
 * @file
 * Dependent selects: each level only shows options whose parent is selected
 * in the level above (or, if that level is empty, any option allowed there).
 */
(function (Drupal, drupalSettings, once) {
  const EMPTY = ['', '_none', 'All'];
  const isEmpty = (v) => EMPTY.includes(v);

  function setup(form, levels) {
    // Skip levels that are not rendered as a select (e.g. an autocomplete).
    levels = levels.filter((l) => form.querySelector(`select[name="${l.name}"]`));
    if (levels.length < 2) {
      return;
    }
    const selects = levels.map((l) => form.querySelector(`select[name="${l.name}"]`));
    // Keep a copy of every original option so options can be restored.
    const originals = selects.map((s) =>
      Array.from(s.options).map((o) => ({ value: o.value, text: o.text })),
    );

    function refresh(fromIndex) {
      // allowed: Set of values allowed at the level, or null = no restriction.
      let constraint = null;
      for (let i = 0; i < selects.length; i++) {
        const select = selects[i];
        let allowed = null;
        if (i > 0 && constraint !== null) {
          const parents = levels[i].parents || {};
          allowed = new Set(
            originals[i]
              .filter((o) => !isEmpty(o.value) && (parents[o.value] || []).some((p) => constraint.has(p)))
              .map((o) => o.value),
          );
        }
        if (i > fromIndex) {
          const current = select.value;
          select.innerHTML = '';
          originals[i].forEach((o) => {
            if (isEmpty(o.value) || allowed === null || allowed.has(o.value)) {
              select.add(new Option(o.text, o.value));
            }
          });
          const stillThere = Array.from(select.options).some((o) => o.value === current);
          select.value = stillThere ? current : select.options[0].value;
        }
        // Constraint passed to the next level.
        if (!isEmpty(select.value)) {
          constraint = new Set([select.value]);
        }
        else {
          constraint = allowed;
        }
      }
    }

    selects.forEach((s, i) => s.addEventListener('change', () => refresh(i)));
    refresh(0);
  }

  Drupal.behaviors.cruiserCascade = {
    attach(context) {
      const config = drupalSettings.cruiserCascade || {};
      Object.values(config).forEach((cfg) => {
        const selector = cfg.levels.map((l) => `select[name="${l.name}"]`).join(',');
        const forms = new Set();
        once('cruiser-cascade', selector, context).forEach((el) => forms.add(el.closest('form')));
        forms.forEach((form) => setup(form, cfg.levels));
      });
    },
  };
})(Drupal, drupalSettings, once);
