<?php

/**
 * @file
 * Theme settings form for the Tailpine theme.
 *
 * Provides color scheme selection, custom color overrides, header/footer
 * style pickers, and layout settings.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\canvas\Entity\PageRegion;
use Drupal\tailpine\TailpineColors;

/**
 * Implements hook_form_FORM_ID_alter().
 */
function tailpine_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {

  // Migrate legacy config keys (safe to call repeatedly — no-op once done).
  TailpineColors::migrateLegacyConfig();

  $form['#attached']['library'][] = 'tailpine/color-picker';

  // General "alters" use a form id. Settings should not be set here. The only
  // thing useful about this is if you need to alter the form for the running
  // theme and *not* the theme setting.
  // @see http://drupal.org/node/943212
  if (isset($form_id)) {
    return;
  }

  // Canvas adds its controls later, during the module form alters.
  // Change collapsible fieldsets (now details) to default #open => FALSE.
  $form['theme_settings']['#open'] = FALSE;
  $form['logo']['#open'] = FALSE;
  $form['favicon']['#open'] = FALSE;

    $form['#attributes']['class'][] = 'tailpine-settings';  
  // ------------------------------------------------------------------
  // Vertical tabs.
  // ------------------------------------------------------------------
  $form['tailpine'] = [
    '#type' => 'vertical_tabs',
    '#prefix' => '<h2><small>' . t('Tailpine settings') . '</small></h2>',
    '#weight' => -10,
  ];

  // Color scheme tab.
  $form['colors'] = [
    '#type' => 'details',
    '#title' => t('Color scheme'),
    '#group' => 'tailpine',
  ];

  // Header styles tab.
  $form['header_settings'] = [
    '#type' => 'details',
    '#title' => t('Header styles'),
    '#group' => 'tailpine',
  ];

  // Footer styles tab.
  $form['footer_settings'] = [
    '#type' => 'details',
    '#title' => t('Footer styles'),
    '#group' => 'tailpine',
  ];

  // Layout settings tab.
  $form['layout_settings'] = [
    '#type' => 'details',
    '#title' => t('Layout settings'),
    '#group' => 'tailpine',
  ];

  // ------------------------------------------------------------------
  // Color scheme selector.
  // ------------------------------------------------------------------
  $theme_options = [];
  foreach (TailpineColors::THEMES as $key => $theme) {
    $theme_options[$key] = $theme['label'];
  }
  $theme_options['custom'] = t('Custom — uses colors defined below');

  $form['colors']['color_theme'] = [
    '#type' => 'select',
    '#title' => t('Color scheme'),
    '#description' => t('Select the color theme applied site-wide. This sets the <code>data-theme</code> attribute on the &lt;html&gt; element. Choose "Custom" to define your own colors below.'),
    '#default_value' => theme_get_setting('color_theme') ?: 'cyberpunk',
    '#options' => $theme_options,
    '#parents' => ['color_theme'],
  ];

  // Color theme switcher visibility + region.
  $form['colors']['show_color_switcher'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable frontend color theme switcher'),
    '#description' => t('When checked, the color theme switcher renders inside the region selected below.'),
    '#default_value' => theme_get_setting('show_color_switcher') ?? FALSE,
  ];

  $form['colors']['color_switcher_region'] = [
    '#type' => 'select',
    '#title' => t('Color switcher region'),
    '#description' => t('Region where the color theme switcher is rendered.'),
    '#options' => system_region_list('tailpine', REGIONS_VISIBLE),
    '#default_value' => theme_get_setting('color_switcher_region') ?: 'header_actions',
    '#states' => [
      'visible' => [':input[name="show_color_switcher"]' => ['checked' => TRUE]],
    ],
  ];

  // ------------------------------------------------------------------
  // Custom color overrides section.
  // ------------------------------------------------------------------
  $form['colors']['scheme'] = [
    '#type' => 'details',
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
    '#title' => t('Custom color overrides'),
  ];

  $form['colors']['scheme']['tailpine_enable_color'] = [
    '#type' => 'checkbox',
    '#title' => t('Enable custom color scheme'),
    '#description' => t('When enabled and "Custom" is selected as the color scheme above, these values override the default theme colors.'),
    '#config_target' => 'tailpine.settings:tailpine_enable_color',
    '#ajax' => [
      'callback' => 'tailpine_color_callback',
      'wrapper' => 'color_container',
    ],
  ];

  $form['colors']['scheme']['color_container'] = [
    '#type' => 'container',
    '#attributes' => [
      'id' => 'color_container',
    ],
  ];

  // Pass theme color data to JS for the scheme pre-fill dropdown.
  $form['#attached']['drupalSettings']['tailpine']['colorSchemes'] = [
    'schemeColors' => TailpineColors::getThemesForJs(),
  ];

  if ($form_state->getValue('tailpine_enable_color', theme_get_setting('tailpine_enable_color'))) {
    // Scheme pre-fill dropdown — selects a predefined theme as a starting
    // point and populates all 22 color fields via JavaScript.
    $scheme_options = [];
    foreach (TailpineColors::THEMES as $key => $theme) {
      $scheme_options[$key] = $theme['label'];
    }

    $form['colors']['scheme']['color_container']['tailpine_color_scheme'] = [
      '#type' => 'select',
      '#title' => t('Start from a predefined theme'),
      '#empty_option' => t('— Select to pre-fill —'),
      '#empty_value' => '',
      '#options' => $scheme_options,
      '#input' => FALSE,
      '#attributes' => [
        'data-drupal-selector' => 'edit-tailpine-color-scheme-site',
        'data-category' => 'schemeColors',
      ],
      '#wrapper_attributes' => [
        'style' => 'display:none;',
      ],
    ];

    // Build grouped fieldsets with the 22 color fields.
    foreach (TailpineColors::GROUPS as $group_key => $group_label) {
      $form['colors']['scheme']['color_container']['group_' . $group_key] = [
        '#type' => 'details',
        '#title' => t('@label', ['@label' => $group_label]),
        '#open' => ($group_key === 'brand'),
      ];
    }

    $index = 0;
    foreach (TailpineColors::VARIABLES as $var_name => $meta) {
      $index++;
      $setting_key = TailpineColors::getSettingKey($var_name);
      $group_key = 'group_' . $meta['group'];
      $is_shadow = ($var_name === 'shadow');

      // Only use explicitly saved config; empty until user picks a value.
      $default = theme_get_setting($setting_key) ?: '';

      $form['colors']['scheme']['color_container'][$group_key][$setting_key] = [
        '#type' => 'textfield',
        '#maxlength' => $is_shadow ? 40 : 7,
        '#size' => $is_shadow ? 30 : 10,
        '#title' => t('@label', ['@label' => $meta['label']]),
        '#default_value' => $default,
        '#description' => $index === 1 ? t('Enter color in full hexadecimal format (#abc123).') . '<br/>' . t('Derivatives will be formed from this color.') : '',
        '#config_target' => "tailpine.settings:$setting_key",
        '#attributes' => $is_shadow ? [] : [
          'pattern' => '^[#]?([0-9a-fA-F]{3}){1,2}$',
        ],
        '#wrapper_attributes' => $is_shadow ? [] : [
          'data-drupal-selector' => 'tailpine-color-picker',
        ],
      ];

      // Add a description for the shadow field.
      if ($is_shadow) {
        $form['colors']['scheme']['color_container'][$group_key][$setting_key]['#description'] = t('Accepts rgba() values, e.g. <code>rgba(0, 0, 0, 0.1)</code>.');
      }
    }
  }

  // ------------------------------------------------------------------
  // Header settings.
  // ------------------------------------------------------------------
  $form['header_settings']['header_settings_container']['header_class'] = [
    '#type' => 'select',
    '#title' => t('Choose a header style'),
    '#default_value' => theme_get_setting('header_class'),
    '#options' => [
      'style1' => t('Style 1: Branding left, Menu and Search right'),
      'style2' => t('Style 2: Branding left, Menu and Actions right'),
      'style3' => t('Style 3: Branding Left, Menu Center, Search right'),
      'style4' => t('Style 4: Branding left, Menu Center, Actions right'),
    ],
  ];

  $form['header_settings']['header_settings_container']['header_fixed'] = [
    '#type' => 'checkbox',
    '#title' => t('Fix header to top'),
    '#default_value' => theme_get_setting('header_fixed'),
    '#description' => t('If checked, the header will stay fixed at the top of the screen.'),
  ];
  // ------------------------------------------------------------------
  // Hide the Header styles tab entirely when Drupal Canvas page
  // templates are enabled for this theme — Canvas controls the page
  // structure directly, so the classic header style picker no longer
  // applies. Checked against the real Canvas state (PageRegion config
  // entities), not just the checkbox's momentary UI value.
  // ------------------------------------------------------------------
  $canvas_theme = $form_state->getBuildInfo()['args'][0] ?? NULL;
  $canvas_enabled = FALSE;
  if ($canvas_theme) {
    $page_regions = PageRegion::loadForTheme($canvas_theme);
    $canvas_enabled = !empty($page_regions);
  }
  $form['header_settings']['#access'] = !$canvas_enabled;

  // ------------------------------------------------------------------
  // Footer settings.
  // ------------------------------------------------------------------
  $form['footer_settings']['footer_settings_container']['footer_class'] = [
    '#type' => 'select',
    '#title' => t('Choose a footer style'),
    '#default_value' => theme_get_setting('footer_class'),
    '#options' => [
      'style1' => t('Style 1: Canvas Layout Footer'),
      'style2' => t('Style 2: Style Two'),
    ],
  ];
  $form['footer_settings']['#access'] = !$canvas_enabled;
  // ------------------------------------------------------------------
  // Layout settings.
  // ------------------------------------------------------------------
  $form['layout_settings']['layout_settings_container']['container_style'] = [
    '#type' => 'select',
    '#title' => t('Page container width'),
    '#description' => t('Controls the maximum width of the main content area across all pages. Uses Tailwind CSS v4 utility classes.'),
    '#default_value' => theme_get_setting('container_style') ?: 'full',
    '#options' => [
      'full'   => t('Full Width — Edge to Edge'),
      'fluid'  => t('Fluid — Full Background, Centered Content'),
      'wide'   => t('Wide — 1920px'),
      'xl'     => t('Extra Large — 1536px'),
      'lg'     => t('Large — 1280px'),
      'md'     => t('Medium — 1024px'),
    ],
  ];

  // Container padding.
  $form['layout_settings']['layout_settings_container']['container_padding_mobile'] = [
    '#type' => 'number',
    '#title' => t('Container Inline Spacing - Mobile - 390'),
    '#default_value' => theme_get_setting('container_padding_mobile') ?: 20,
    '#min' => 0,
    '#field_suffix' => 'px',
  ];

  $form['layout_settings']['layout_settings_container']['container_padding_tablet'] = [
    '#type' => 'number',
    '#title' => t('Container Inline Spacing - Tablet - 768'),
    '#default_value' => theme_get_setting('container_padding_tablet') ?: 60,
    '#min' => 0,
    '#field_suffix' => 'px',
  ];

  $form['layout_settings']['layout_settings_container']['container_padding_desktop'] = [
    '#type' => 'number',
    '#title' => t('Container Inline Spacing - Desktop - 1280'),
    '#default_value' => theme_get_setting('container_padding_desktop') ?: 96,
    '#min' => 0,
    '#field_suffix' => 'px',
  ];

  $form['layout_settings']['layout_settings_container']['container_padding_wide'] = [
    '#type' => 'number',
    '#title' => t('Container Inline Spacing - Wide desktop - 1920'),
    '#default_value' => theme_get_setting('container_padding_wide') ?: 120,
    '#min' => 0,
    '#field_suffix' => 'px',
  ];

  // ------------------------------------------------------------------
  // Auto-switch to "custom" when colors are customized.
  // ------------------------------------------------------------------
  $form['#submit'][] = 'tailpine_color_settings_submit';
  // Typography settings.
  $form['typography'] = [
    '#type' => 'details',
    '#title' => t('Typography Settings'),
    '#open' => TRUE,
  ];

  // Body font size.
  $form['typography']['body_font_size'] = [
    '#type' => 'textfield',
    '#title' => t('Body Font Size (px)'),
    '#default_value' => theme_get_setting('body_font_size') ?: '16',
    '#description' => t('Base font size for body text. Example: 16'),
  ];

  // Body font family.
  $form['typography']['body_font_family'] = [
    '#type' => 'select',
    '#title' => t('Body Font Family'),
    '#options' => [
      'inter' => t('Inter (Default)'),
      'opensans' => t('OpenSans'),
      'montserrat' => t('Montserrat'),
      'custom' => t('Custom Body Font'),
    ],
    '#default_value' => theme_get_setting('body_font_family') ?: 'inter',
  ];

  // Heading font family.
  $form['typography']['heading_font_family'] = [
    '#type' => 'select',
    '#title' => t('Heading Font Family'),
    '#options' => [
      'inter' => t('Inter'),
      'opensans' => t('OpenSans'),
      'montserrat' => t('Montserrat'),
      'custom' => t('Custom Heading Font'),
    ],
    '#default_value' => theme_get_setting('heading_font_family') ?: 'opensans',
  ];

  $form['logo']['tailpine_logo_size'] = [
    '#type' => 'container',
    '#attributes' => [
      'class' => ['tailpine-logo-size'],
    ],
  ];

  // Add fields for mobile, tablet, and desktop logo sizes.
  $form['logo']['tailpine_customize_logo_size'] = [
    '#type' => 'checkbox',
    '#title' => t('Customize responsive logo size'),
    '#description' => t('Enable this option to control the logo width for mobile, tablet, and desktop screens. The logo height will adjust automatically to preserve its original aspect ratio.'),
    '#default_value' => theme_get_setting('tailpine_customize_logo_size'),
    '#weight' => 1,
  ];

  $form['logo']['tailpine_logo_size'] = [
    '#type' => 'container',
    '#attributes' => [
      'class' => ['tailpine-logo-size'],
    ],
    '#states' => [
      'visible' => [
        ':input[name="tailpine_customize_logo_size"]' => [
          'checked' => TRUE,
        ],
      ],
    ],
    '#weight' => 2,
  ];

  $form['logo']['tailpine_logo_size']['responsive_logo_mobile'] = [
    '#type' => 'number',
    '#title' => t('Logo width on mobile'),
    '#default_value' => theme_get_setting('responsive_logo_mobile') ?: 73,
    '#min' => 1,
    '#field_suffix' => 'px',
    '#weight' => 1,
  ];

  $form['logo']['tailpine_logo_size']['responsive_logo_tablet'] = [
    '#type' => 'number',
    '#title' => t('Logo width on tablet'),
    '#default_value' => theme_get_setting('responsive_logo_tablet') ?: 80,
    '#min' => 1,
    '#field_suffix' => 'px',
    '#weight' => 2,
  ];

  $form['logo']['tailpine_logo_size']['responsive_logo_desktop'] = [
    '#type' => 'number',
    '#title' => t('Logo width on desktop'),
    '#default_value' => theme_get_setting('responsive_logo_desktop') ?: 100,
    '#min' => 1,
    '#field_suffix' => 'px',
    '#weight' => 3,
  ];

  // Heading typography settings.
$heading_defaults = [
  'h1' => [
    'label' => 'H1 — Page Title',
    'mobile' => 40,
    'tablet' => 52,
    'desktop' => 64,
    'wide_desktop' => 72,
  ],
  'h2' => [
    'label' => 'H2 — Section Heading',
    'mobile' => 32,
    'tablet' => 40,
    'desktop' => 48,
    'wide_desktop' => 56,
  ],
  'h3' => [
    'label' => 'H3 — Subsection Heading',
    'mobile' => 26,
    'tablet' => 32,
    'desktop' => 40,
    'wide_desktop' => 44,
  ],
  'h4' => [
    'label' => 'H4 — Card Heading',
    'mobile' => 22,
    'tablet' => 26,
    'desktop' => 30,
    'wide_desktop' => 32,
  ],
  'h5' => [
    'label' => 'H5 — Small Heading',
    'mobile' => 18,
    'tablet' => 20,
    'desktop' => 22,
    'wide_desktop' => 24,
  ],
  'h6' => [
    'label' => 'H6 — Minor Heading',
    'mobile' => 16,
    'tablet' => 18,
    'desktop' => 18,
    'wide_desktop' => 20,
  ],
];

$breakpoints = [
  'mobile' => [
    'label' => t('Mobile'),
    'viewport' => '390px',
  ],
  'tablet' => [
    'label' => t('Tablet'),
    'viewport' => '768px',
  ],
  'desktop' => [
    'label' => t('Desktop'),
    'viewport' => '1280px',
  ],
  'wide_desktop' => [
    'label' => t('Wide Desktop'),
    'viewport' => '1920px',
  ],
];

// Attach the theme administration stylesheet.
$form['#attached']['library'][] = 'tailpine/admin';

// Main heading typography section.
$form['typography']['heading_sizes'] = [
  '#type' => 'details',
  '#title' => t('Heading Sizes'),
  '#description' => t('Configure responsive font sizes for heading elements across four viewport sizes. Values are specified in pixels.'),
  '#open' => FALSE,
  '#attributes' => [
    'class' => ['tailpine-heading-settings'],
  ],
];

foreach ($heading_defaults as $heading => $settings) {
  $form['typography']['heading_sizes'][$heading] = [
    '#type' => 'details',
    '#title' => t($settings['label']),
    '#open' => $heading === 'h1',
    '#attributes' => [
      'class' => [
        'tailpine-heading-settings__item',
        'tailpine-heading-settings__item--' . $heading,
      ],
    ],
  ];

  $form['typography']['heading_sizes'][$heading]['sizes'] = [
    '#type' => 'container',
    '#attributes' => [
      'class' => ['tailpine-typography-row'],
    ],
  ];

  foreach ($breakpoints as $breakpoint => $breakpoint_settings) {
    $setting_name = $heading . '_' . $breakpoint;
    $saved_value = theme_get_setting($setting_name);

    $form['typography']['heading_sizes'][$heading]['sizes'][$breakpoint] = [
      '#type' => 'number',
      '#title' => $breakpoint_settings['label'],
      '#default_value' => ($saved_value !== NULL && $saved_value !== '')
        ? $saved_value
        : $settings[$breakpoint],
      '#min' => 1,
      '#max' => 300,
      '#step' => 1,
      '#field_suffix' => 'px',
      '#description' => t('Viewport: @viewport', [
        '@viewport' => $breakpoint_settings['viewport'],
      ]),
      '#parents' => [$setting_name],
      '#attributes' => [
        'class' => ['tailpine-typography-grid__field'],
      ],
      '#wrapper_attributes' => [
        'class' => ['tailpine-typography-grid__item'],
      ],
    ];
  }
}

}

/**
 * Handles the color callback for the theme settings form.
 *
 * @param array $form
 *   The form array.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The form state interface.
 *
 * @return array
 *   The color container portion of the form.
 */
function tailpine_color_callback(array $form, FormStateInterface $form_state): array {
  return $form['colors']['scheme']['color_container'];
}

/**
 * Submit handler: switches color_theme to "custom" when colors are modified.
 *
 * If the admin has enabled custom colors and any of the 22 color values
 * differ from the currently selected predefined theme, the color_theme
 * setting is automatically changed to "custom".
 *
 * @param array $form
 *   The form array.
 * @param \Drupal\Core\Form\FormStateInterface $form_state
 *   The form state interface.
 */
function tailpine_color_settings_submit(array $form, FormStateInterface $form_state): void {
  // When custom colors are disabled, revert color_theme away from "custom"
  // so the page does not keep rendering with data-theme="custom".
  if (!$form_state->getValue('tailpine_enable_color')) {
    if ($form_state->getValue('color_theme') === 'custom') {
      $form_state->setValue('color_theme', 'emerald');
    }
    return;
  }

  $color_theme = $form_state->getValue('color_theme');
  if ($color_theme === 'custom') {
    return;
  }

  $theme_colors = TailpineColors::THEMES[$color_theme]['colors'] ?? [];
  if (empty($theme_colors)) {
    return;
  }

  foreach (TailpineColors::VARIABLES as $var_name => $meta) {
    $key = TailpineColors::getSettingKey($var_name);
    $saved = $form_state->getValue($key);
    $default = $theme_colors[$var_name] ?? '';
    if ($saved && $saved !== $default) {
      $form_state->setValue('color_theme', 'custom');
      return;
    }
  }
}
