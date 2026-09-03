<?php

/**
 * @file
 * Theme settings form for the Tailpine theme.
 *
 * Provides color scheme selection, custom color overrides, header/footer
 * style pickers, and layout settings.
 */

use Drupal\Core\Form\FormStateInterface;
use Drupal\tailpine\TailpineColors;

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * Adds the "My Brand" option to the color scheme dropdown defined by
 * the Tailpine base theme, without touching TailpineColors or the
 * base theme's settings form logic.
 */
/**
 * Custom color themes provided by this subtheme.
 *
 * Keep this in sync with the [data-theme="..."] blocks defined in
 * css/main.css — add a new key here whenever you add a new block there.
 */
const MYTHEME_CUSTOM_COLOR_THEMES = [
  'mybrand' => 'My Brand'
];

/**
 * Implements hook_form_FORM_ID_alter().
 */
function cruiserclassic_form_system_theme_settings_alter(&$form, FormStateInterface $form_state, $form_id = NULL) {
  if (isset($form_id)) {
    return;
  }

  if (isset($form['colors']['color_theme']['#options'])) {
    foreach (MYTHEME_CUSTOM_COLOR_THEMES as $key => $label) {
      $form['colors']['color_theme']['#options'][$key] = t($label);
    }
  }
}