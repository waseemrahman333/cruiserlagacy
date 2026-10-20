<?php

namespace Drupal\tailpine;

/**
 * Canonical source for Tailpine color theme data.
 *
 * Holds the 22 CSS custom-property definitions, their form labels and groups,
 * the complete 27-theme color map extracted from css/main.css, and helper
 * methods used by theme-settings.php, tailpine.theme, and the
 * ColorThemeSwitcherBlock plugin.
 */
final class TailpineColors {

  /**
   * Ordered map of CSS variable suffixes to form metadata.
   *
   * Each key is the suffix used in --t-{key}. The 'label' is the human-
   * readable form label, and 'group' determines which fieldset the field
   * appears in on the theme-settings form.
   */
  const VARIABLES = [
    'primary'      => ['label' => 'Primary', 'group' => 'brand'],
    'on-primary'   => ['label' => 'On primary (text on primary bg)', 'group' => 'brand'],

    'secondary'    => ['label' => 'Secondary', 'group' => 'brand'],
    'on-secondary' => ['label' => 'On secondary (text on secondary bg)', 'group' => 'brand'],

    'tertiary'     => ['label' => 'Tertiary', 'group' => 'brand'],
    'on-tertiary'  => ['label' => 'On tertiary (text on tertiary bg)', 'group' => 'brand'],

    'body'         => ['label' => 'Body text', 'group' => 'typography'],
    'heading'      => ['label' => 'Heading text', 'group' => 'typography'],

    'body-bg'      => ['label' => 'Body background', 'group' => 'backgrounds'],
    'surface-100'  => ['label' => 'Surface 100 (light)', 'group' => 'backgrounds'],
    'surface-200'  => ['label' => 'Surface 200 (medium)', 'group' => 'backgrounds'],
    'surface-300'  => ['label' => 'Surface 300 (strong)', 'group' => 'backgrounds'],

    'border'       => ['label' => 'Border', 'group' => 'ui'],
    'focus-ring'   => ['label' => 'Focus ring', 'group' => 'ui'],
    'shadow'       => ['label' => 'Shadow', 'group' => 'ui'],
    'dark'       => ['label' => 'Dark', 'group' => 'ui'],

    'success'      => ['label' => 'Success', 'group' => 'status'],
    'on-success'   => ['label' => 'On success (text on success bg)', 'group' => 'status'],

    'warning'      => ['label' => 'Warning', 'group' => 'status'],
    'on-warning'   => ['label' => 'On warning (text on warning bg)', 'group' => 'status'],

    'error'        => ['label' => 'Error', 'group' => 'status'],
    'on-error'     => ['label' => 'On error (text on error bg)', 'group' => 'status'],

    'info'         => ['label' => 'Info', 'group' => 'status'],
    'on-info'      => ['label' => 'On info (text on info bg)', 'group' => 'status'],
  ];

  /**
   * Fieldset labels for each variable group.
   */
  const GROUPS = [
    'brand'       => 'Brand colors',
    'typography'  => 'Typography',
    'backgrounds' => 'Backgrounds & surfaces',
    'ui'          => 'UI elements',
    'status'      => 'Status colors',
  ];

  /**
   * Complete 27-theme color map extracted from css/main.css.
   *
   * Each theme provides all 22 --t-* values. Keys match the data-theme
   * attribute values used in the CSS.
   *
   * @see css/main.css
   */
  const THEMES = [
    'emerald' => [
      'label' => 'Emerald',
      'colors' => [
        'primary' => '#10B981', 'on-primary' => '#FFFFFF',
        'secondary' => '#064E3B', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#06B6D4', 'on-tertiary' => '#FFFFFF',
        'body' => '#1F2937', 'heading' => '#111827',
        'body-bg' => '#FFFFFF', 'surface-100' => '#FFFFFF',
        'surface-200' => '#F9FAFB', 'surface-300' => '#F3F4F6',
        'border' => '#E5E7EB', 'dark' => '#111827',
        'focus-ring' => '#34D399', 'shadow' => 'rgba(0, 0, 0, 0.1)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#B91C1C', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
    'midnight' => [
      'label' => 'Midnight',
      'colors' => [
        'primary' => '#3B82F6', 'on-primary' => '#FFFFFF',
        'secondary' => '#1E3A8A', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#8B5CF6', 'on-tertiary' => '#FFFFFF',
        'body' => '#F3F4F6', 'heading' => '#FFFFFF',
        'body-bg' => '#0B1120', 'surface-100' => '#0B1120',
        'surface-200' => '#1E293B', 'surface-300' => '#334155',
        'border' => '#334155', 'dark' => '#020617',
        'focus-ring' => '#93C5FD', 'shadow' => 'rgba(0, 0, 0, 0.4)',
        'success' => '#4ADE80', 'on-success' => '#052E16',
        'warning' => '#FBBF24', 'on-warning' => '#451A03',
        'error' => '#F87171', 'on-error' => '#450A0A',
        'info' => '#38BDF8', 'on-info' => '#082F49',
      ],
    ],
    'coffee' => [
      'label' => 'Coffee',
      'colors' => [
        'primary' => '#D97706', 'on-primary' => '#FFFFFF',
        'secondary' => '#78350F', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#EA580C', 'on-tertiary' => '#FFFFFF',
        'body' => '#451A03', 'heading' => '#290E01',
        'body-bg' => '#FFFBEB', 'surface-100' => '#FFFBEB',
        'surface-200' => '#FEF3C7', 'surface-300' => '#FDE68A',
        'border' => '#FCD34D', 'dark' => '#451A03',
        'focus-ring' => '#FBBF24', 'shadow' => 'rgba(69, 26, 3, 0.08)',
        'success' => '#166534', 'on-success' => '#FFFFFF',
        'warning' => '#D97706', 'on-warning' => '#FFFFFF',
        'error' => '#991B1B', 'on-error' => '#FFFFFF',
        'info' => '#075985', 'on-info' => '#FFFFFF',
      ],
    ],
    'cyberpunk' => [
      'label' => 'Cyberpunk',
      'colors' => [
        'primary' => '#F0ABFC', 'on-primary' => '#4A044E',
        'secondary' => '#701A75', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#2DD4BF', 'on-tertiary' => '#042F2E',
        'body' => '#E5E7EB', 'heading' => '#FDF4FF',
        'body-bg' => '#12091A', 'surface-100' => '#12091A',
        'surface-200' => '#271432', 'surface-300' => '#3B1E4A',
        'border' => '#4A044E', 'dark' => '#000000',
        'focus-ring' => '#F0ABFC', 'shadow' => 'rgba(240, 171, 252, 0.2)',
        'success' => '#2DD4BF', 'on-success' => '#042F2E',
        'warning' => '#FDE047', 'on-warning' => '#451A03',
        'error' => '#FB7185', 'on-error' => '#4C0519',
        'info' => '#22D3EE', 'on-info' => '#083344',
      ],
    ],
    'ocean' => [
      'label' => 'Ocean',
      'colors' => [
        'primary' => '#0EA5E9', 'on-primary' => '#FFFFFF',
        'secondary' => '#0C4A6E', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#06B6D4', 'on-tertiary' => '#FFFFFF',
        'body' => '#1E293B', 'heading' => '#0F172A',
        'body-bg' => '#F0F9FF', 'surface-100' => '#F0F9FF',
        'surface-200' => '#E0F2FE', 'surface-300' => '#BAE6FD',
        'border' => '#7DD3FC', 'dark' => '#082F49',
        'focus-ring' => '#38BDF8', 'shadow' => 'rgba(12, 74, 110, 0.1)',
        'success' => '#059669', 'on-success' => '#FFFFFF',
        'warning' => '#CA8A04', 'on-warning' => '#FFFFFF',
        'error' => '#DC2626', 'on-error' => '#FFFFFF',
        'info' => '#0284C7', 'on-info' => '#FFFFFF',
      ],
    ],
    'forest' => [
      'label' => 'Forest',
      'colors' => [
        'primary' => '#4ADE80', 'on-primary' => '#064E3B',
        'secondary' => '#14532D', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#A3E635', 'on-tertiary' => '#1A2E05',
        'body' => '#ECFDF5', 'heading' => '#ECFDF5',
        'body-bg' => '#064E3B', 'surface-100' => '#064E3B',
        'surface-200' => '#065F46', 'surface-300' => '#047857',
        'border' => '#059669', 'dark' => '#022C22',
        'focus-ring' => '#4ADE80', 'shadow' => 'rgba(0, 0, 0, 0.3)',
        'success' => '#6EE7B7', 'on-success' => '#022C22',
        'warning' => '#FCD34D', 'on-warning' => '#451A03',
        'error' => '#FCA5A5', 'on-error' => '#450A0A',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'crimson' => [
      'label' => 'Crimson',
      'colors' => [
        'primary' => '#E11D48', 'on-primary' => '#FFFFFF',
        'secondary' => '#881337', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#FB7185', 'on-tertiary' => '#FFFFFF',
        'body' => '#3F3F46', 'heading' => '#18181B',
        'body-bg' => '#FFFFFF', 'surface-100' => '#FFFFFF',
        'surface-200' => '#F8F8F8', 'surface-300' => '#ECECEC',
        'border' => '#FECDD3', 'dark' => '#111827',
        'focus-ring' => '#FB7185', 'shadow' => 'rgba(136, 19, 55, 0.08)',
        'success' => '#059669', 'on-success' => '#FFFFFF',
        'warning' => '#D97706', 'on-warning' => '#FFFFFF',
        'error' => '#BE123C', 'on-error' => '#FFFFFF',
        'info' => '#0284C7', 'on-info' => '#FFFFFF',
      ],
    ],
    'amber' => [
      'label' => 'Amber',
      'colors' => [
        'primary' => '#F59E0B', 'on-primary' => '#451A03',
        'secondary' => '#78350F', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#D97706', 'on-tertiary' => '#FFFFFF',
        'body' => '#FFF7ED', 'heading' => '#FFFFFF',
        'body-bg' => '#171717', 'surface-100' => '#171717',
        'surface-200' => '#262626', 'surface-300' => '#404040',
        'border' => '#525252', 'dark' => '#000000',
        'focus-ring' => '#F59E0B', 'shadow' => 'rgba(0, 0, 0, 0.5)',
        'success' => '#34D399', 'on-success' => '#022C22',
        'warning' => '#FDE047', 'on-warning' => '#451A03',
        'error' => '#F87171', 'on-error' => '#450A0A',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'mono-light' => [
      'label' => 'Mono Light',
      'colors' => [
        'primary' => '#000000', 'on-primary' => '#FFFFFF',
        'secondary' => '#555555', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#777777', 'on-tertiary' => '#FFFFFF',
        'body' => '#000000', 'heading' => '#000000',
        'body-bg' => '#FFFFFF', 'surface-100' => '#FFFFFF',
        'surface-200' => '#F5F5F5', 'surface-300' => '#E0E0E0',
        'border' => '#000000', 'dark' => '#000000',
        'focus-ring' => '#000000', 'shadow' => 'rgba(0, 0, 0, 0.15)',
        'success' => '#000000', 'on-success' => '#FFFFFF',
        'warning' => '#555555', 'on-warning' => '#FFFFFF',
        'error' => '#000000', 'on-error' => '#FFFFFF',
        'info' => '#000000', 'on-info' => '#FFFFFF',
      ],
    ],
    'mono-dark' => [
      'label' => 'Mono Dark',
      'colors' => [
        'primary' => '#FFFFFF', 'on-primary' => '#000000',
        'secondary' => '#AAAAAA', 'on-secondary' => '#000000',
        'tertiary' => '#888888', 'on-tertiary' => '#000000',
        'body' => '#FFFFFF', 'heading' => '#FFFFFF',
        'body-bg' => '#000000', 'surface-100' => '#000000',
        'surface-200' => '#1A1A1A', 'surface-300' => '#333333',
        'border' => '#FFFFFF', 'dark' => '#000000',
        'focus-ring' => '#FFFFFF', 'shadow' => 'rgba(255, 255, 255, 0.1)',
        'success' => '#FFFFFF', 'on-success' => '#000000',
        'warning' => '#CCCCCC', 'on-warning' => '#000000',
        'error' => '#FFFFFF', 'on-error' => '#000000',
        'info' => '#FFFFFF', 'on-info' => '#000000',
      ],
    ],
    'sakura' => [
      'label' => 'Sakura',
      'colors' => [
        'primary' => '#DB2777', 'on-primary' => '#FFFFFF',
        'secondary' => '#9D174D', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#F472B6', 'on-tertiary' => '#4C0519',
        'body' => '#44262F', 'heading' => '#2B0F1A',
        'body-bg' => '#FFF7F9', 'surface-100' => '#FFF7F9',
        'surface-200' => '#FCE7F3', 'surface-300' => '#FBCFE8',
        'border' => '#F9A8D4', 'dark' => '#44262F',
        'focus-ring' => '#F472B6', 'shadow' => 'rgba(157, 23, 77, 0.1)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#BE123C', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
    'linen' => [
      'label' => 'Linen',
      'colors' => [
        'primary' => '#1C1917', 'on-primary' => '#FAFAF9',
        'secondary' => '#78716C', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#A8A29E', 'on-tertiary' => '#1C1917',
        'body' => '#292524', 'heading' => '#0C0A09',
        'body-bg' => '#FAFAF9', 'surface-100' => '#FAFAF9',
        'surface-200' => '#F5F5F4', 'surface-300' => '#E7E5E4',
        'border' => '#D6D3D1', 'dark' => '#0C0A09',
        'focus-ring' => '#1C1917', 'shadow' => 'rgba(12, 10, 9, 0.08)',
        'success' => '#4D7C0F', 'on-success' => '#FFFFFF',
        'warning' => '#A16207', 'on-warning' => '#FFFFFF',
        'error' => '#991B1B', 'on-error' => '#FFFFFF',
        'info' => '#1E40AF', 'on-info' => '#FFFFFF',
      ],
    ],
    'solstice' => [
      'label' => 'Solstice',
      'colors' => [
        'primary' => '#CA8A04', 'on-primary' => '#FEFCE8',
        'secondary' => '#713F12', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#EAB308', 'on-tertiary' => '#3F2F0A',
        'body' => '#3F2F0A', 'heading' => '#1C1203',
        'body-bg' => '#FEFCE8', 'surface-100' => '#FEFCE8',
        'surface-200' => '#FEF9C3', 'surface-300' => '#FEF08A',
        'border' => '#FDE68A', 'dark' => '#3F2F0A',
        'focus-ring' => '#EAB308', 'shadow' => 'rgba(133, 77, 14, 0.1)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#B91C1C', 'on-error' => '#FFFFFF',
        'info' => '#0E7490', 'on-info' => '#FFFFFF',
      ],
    ],
    'lavender' => [
      'label' => 'Lavender',
      'colors' => [
        'primary' => '#7C3AED', 'on-primary' => '#FFFFFF',
        'secondary' => '#4C1D95', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#A78BFA', 'on-tertiary' => '#2E1065',
        'body' => '#2E1065', 'heading' => '#1E0B4E',
        'body-bg' => '#FAF5FF', 'surface-100' => '#FAF5FF',
        'surface-200' => '#F3E8FF', 'surface-300' => '#E9D5FF',
        'border' => '#D8B4FE', 'dark' => '#2E1065',
        'focus-ring' => '#A78BFA', 'shadow' => 'rgba(76, 29, 149, 0.08)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#B91C1C', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
    'sage' => [
      'label' => 'Sage',
      'colors' => [
        'primary' => '#4D7C0F', 'on-primary' => '#F7FEE7',
        'secondary' => '#365314', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#84CC16', 'on-tertiary' => '#1A2E05',
        'body' => '#1A2E05', 'heading' => '#0F1A02',
        'body-bg' => '#F7FEE7', 'surface-100' => '#F7FEE7',
        'surface-200' => '#ECFCCB', 'surface-300' => '#D9F99D',
        'border' => '#BEF264', 'dark' => '#1A2E05',
        'focus-ring' => '#84CC16', 'shadow' => 'rgba(77, 124, 15, 0.08)',
        'success' => '#4D7C0F', 'on-success' => '#FFFFFF',
        'warning' => '#A16207', 'on-warning' => '#FFFFFF',
        'error' => '#B91C1C', 'on-error' => '#FFFFFF',
        'info' => '#0E7490', 'on-info' => '#FFFFFF',
      ],
    ],
    'porcelain' => [
      'label' => 'Porcelain',
      'colors' => [
        'primary' => '#0369A1', 'on-primary' => '#F0F9FF',
        'secondary' => '#0C4A6E', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#38BDF8', 'on-tertiary' => '#0C4A6E',
        'body' => '#0F172A', 'heading' => '#020617',
        'body-bg' => '#F8FAFC', 'surface-100' => '#F8FAFC',
        'surface-200' => '#F1F5F9', 'surface-300' => '#E2E8F0',
        'border' => '#CBD5E1', 'dark' => '#0F172A',
        'focus-ring' => '#38BDF8', 'shadow' => 'rgba(15, 23, 42, 0.06)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#BE123C', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
    'terracotta' => [
      'label' => 'Terracotta',
      'colors' => [
        'primary' => '#C2410C', 'on-primary' => '#FFF7ED',
        'secondary' => '#7C2D12', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#EA580C', 'on-tertiary' => '#FFFFFF',
        'body' => '#431407', 'heading' => '#1F0803',
        'body-bg' => '#FFF7ED', 'surface-100' => '#FFF7ED',
        'surface-200' => '#FFEDD5', 'surface-300' => '#FED7AA',
        'border' => '#FDBA74', 'dark' => '#431407',
        'focus-ring' => '#FB923C', 'shadow' => 'rgba(67, 20, 7, 0.1)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#CA8A04', 'on-warning' => '#FFFFFF',
        'error' => '#991B1B', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
    'newsprint' => [
      'label' => 'Newsprint',
      'colors' => [
        'primary' => '#7C2D12', 'on-primary' => '#FEF3C7',
        'secondary' => '#451A03', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#B45309', 'on-tertiary' => '#FFFFFF',
        'body' => '#1C1917', 'heading' => '#0C0A09',
        'body-bg' => '#FAF6EE', 'surface-100' => '#FAF6EE',
        'surface-200' => '#F5EFE0', 'surface-300' => '#EAE2CE',
        'border' => '#D6CDB7', 'dark' => '#0C0A09',
        'focus-ring' => '#B45309', 'shadow' => 'rgba(28, 25, 23, 0.08)',
        'success' => '#4D7C0F', 'on-success' => '#FFFFFF',
        'warning' => '#A16207', 'on-warning' => '#FFFFFF',
        'error' => '#991B1B', 'on-error' => '#FFFFFF',
        'info' => '#1E40AF', 'on-info' => '#FFFFFF',
      ],
    ],
    'obsidian' => [
      'label' => 'Obsidian',
      'colors' => [
        'primary' => '#2DD4BF', 'on-primary' => '#042F2E',
        'secondary' => '#134E4A', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#06B6D4', 'on-tertiary' => '#FFFFFF',
        'body' => '#E5E5E5', 'heading' => '#FAFAFA',
        'body-bg' => '#050505', 'surface-100' => '#050505',
        'surface-200' => '#141414', 'surface-300' => '#1F1F1F',
        'border' => '#262626', 'dark' => '#000000',
        'focus-ring' => '#2DD4BF', 'shadow' => 'rgba(0, 0, 0, 0.6)',
        'success' => '#2DD4BF', 'on-success' => '#042F2E',
        'warning' => '#FBBF24', 'on-warning' => '#451A03',
        'error' => '#F87171', 'on-error' => '#450A0A',
        'info' => '#22D3EE', 'on-info' => '#083344',
      ],
    ],
    'nebula' => [
      'label' => 'Nebula',
      'colors' => [
        'primary' => '#C084FC', 'on-primary' => '#2E1065',
        'secondary' => '#581C87', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#F0ABFC', 'on-tertiary' => '#4A044E',
        'body' => '#EDE9FE', 'heading' => '#F5F3FF',
        'body-bg' => '#1E1B4B', 'surface-100' => '#1E1B4B',
        'surface-200' => '#312E81', 'surface-300' => '#3730A3',
        'border' => '#4338CA', 'dark' => '#0F0A2E',
        'focus-ring' => '#C084FC', 'shadow' => 'rgba(192, 132, 252, 0.15)',
        'success' => '#34D399', 'on-success' => '#022C22',
        'warning' => '#FCD34D', 'on-warning' => '#451A03',
        'error' => '#F472B6', 'on-error' => '#4C0519',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'carbon' => [
      'label' => 'Carbon',
      'colors' => [
        'primary' => '#FB923C', 'on-primary' => '#1C1917',
        'secondary' => '#9A3412', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#F97316', 'on-tertiary' => '#FFFFFF',
        'body' => '#E5E5E5', 'heading' => '#FAFAF9',
        'body-bg' => '#1C1917', 'surface-100' => '#1C1917',
        'surface-200' => '#292524', 'surface-300' => '#44403C',
        'border' => '#57534E', 'dark' => '#0C0A09',
        'focus-ring' => '#FB923C', 'shadow' => 'rgba(0, 0, 0, 0.5)',
        'success' => '#4ADE80', 'on-success' => '#052E16',
        'warning' => '#FBBF24', 'on-warning' => '#451A03',
        'error' => '#F87171', 'on-error' => '#450A0A',
        'info' => '#38BDF8', 'on-info' => '#082F49',
      ],
    ],
    'moss' => [
      'label' => 'Moss',
      'colors' => [
        'primary' => '#A3E635', 'on-primary' => '#1A2E05',
        'secondary' => '#365314', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#84CC16', 'on-tertiary' => '#1A2E05',
        'body' => '#ECFCCB', 'heading' => '#F7FEE7',
        'body-bg' => '#1A2E05', 'surface-100' => '#1A2E05',
        'surface-200' => '#365314', 'surface-300' => '#4D7C0F',
        'border' => '#4D7C0F', 'dark' => '#0F1A02',
        'focus-ring' => '#A3E635', 'shadow' => 'rgba(0, 0, 0, 0.4)',
        'success' => '#86EFAC', 'on-success' => '#052E16',
        'warning' => '#FCD34D', 'on-warning' => '#451A03',
        'error' => '#FCA5A5', 'on-error' => '#450A0A',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'merlot' => [
      'label' => 'Merlot',
      'colors' => [
        'primary' => '#FB7185', 'on-primary' => '#4C0519',
        'secondary' => '#881337', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#F43F5E', 'on-tertiary' => '#FFFFFF',
        'body' => '#FECDD3', 'heading' => '#FFF1F2',
        'body-bg' => '#4C0519', 'surface-100' => '#4C0519',
        'surface-200' => '#6B0F2A', 'surface-300' => '#881337',
        'border' => '#9F1239', 'dark' => '#2D030E',
        'focus-ring' => '#FB7185', 'shadow' => 'rgba(0, 0, 0, 0.4)',
        'success' => '#6EE7B7', 'on-success' => '#022C22',
        'warning' => '#FCD34D', 'on-warning' => '#451A03',
        'error' => '#FCA5A5', 'on-error' => '#450A0A',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'arctic' => [
      'label' => 'Arctic',
      'colors' => [
        'primary' => '#67E8F9', 'on-primary' => '#083344',
        'secondary' => '#0E7490', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#38BDF8', 'on-tertiary' => '#083344',
        'body' => '#E0F2FE', 'heading' => '#F0F9FF',
        'body-bg' => '#0C1E3B', 'surface-100' => '#0C1E3B',
        'surface-200' => '#1E3A5F', 'surface-300' => '#2A4A73',
        'border' => '#1E5A8A', 'dark' => '#050C1B',
        'focus-ring' => '#67E8F9', 'shadow' => 'rgba(0, 0, 0, 0.4)',
        'success' => '#6EE7B7', 'on-success' => '#022C22',
        'warning' => '#FCD34D', 'on-warning' => '#451A03',
        'error' => '#FCA5A5', 'on-error' => '#450A0A',
        'info' => '#67E8F9', 'on-info' => '#083344',
      ],
    ],
    'ember' => [
      'label' => 'Ember',
      'colors' => [
        'primary' => '#F87171', 'on-primary' => '#450A0A',
        'secondary' => '#7F1D1D', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#FB923C', 'on-tertiary' => '#431407',
        'body' => '#FECACA', 'heading' => '#FEF2F2',
        'body-bg' => '#1C1917', 'surface-100' => '#1C1917',
        'surface-200' => '#292524', 'surface-300' => '#44403C',
        'border' => '#7F1D1D', 'dark' => '#0C0A09',
        'focus-ring' => '#F87171', 'shadow' => 'rgba(0, 0, 0, 0.5)',
        'success' => '#86EFAC', 'on-success' => '#052E16',
        'warning' => '#FDE047', 'on-warning' => '#451A03',
        'error' => '#FCA5A5', 'on-error' => '#450A0A',
        'info' => '#7DD3FC', 'on-info' => '#082F49',
      ],
    ],
    'dark' => [
      'label' => 'Dark',
      'colors' => [
        'primary' => '#6366F1', 'on-primary' => '#FFFFFF',
        'secondary' => '#4338CA', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#A5B4FC', 'on-tertiary' => '#1E1B4B',
        'body' => '#CBD5E1', 'heading' => '#F8FAFC',
        'body-bg' => '#0F172A', 'surface-100' => '#0F172A',
        'surface-200' => '#1E293B', 'surface-300' => '#334155',
        'border' => '#334155', 'dark' => '#020617',
        'focus-ring' => '#818CF8', 'shadow' => 'rgba(0, 0, 0, 0.4)',
        'success' => '#4ADE80', 'on-success' => '#052E16',
        'warning' => '#FBBF24', 'on-warning' => '#451A03',
        'error' => '#F87171', 'on-error' => '#450A0A',
        'info' => '#38BDF8', 'on-info' => '#082F49',
      ],
    ],
    'auto' => [
      'label' => 'Auto',
      'colors' => [
        'primary' => '#10B981', 'on-primary' => '#FFFFFF',
        'secondary' => '#064E3B', 'on-secondary' => '#FFFFFF',
        'tertiary' => '#06B6D4', 'on-tertiary' => '#FFFFFF',
        'body' => '#1F2937', 'heading' => '#111827',
        'body-bg' => '#FFFFFF', 'surface-100' => '#FFFFFF',
        'surface-200' => '#F9FAFB', 'surface-300' => '#F3F4F6',
        'border' => '#E5E7EB', 'dark' => '#111827',
        'focus-ring' => '#34D399', 'shadow' => 'rgba(0, 0, 0, 0.1)',
        'success' => '#15803D', 'on-success' => '#FFFFFF',
        'warning' => '#B45309', 'on-warning' => '#FFFFFF',
        'error' => '#B91C1C', 'on-error' => '#FFFFFF',
        'info' => '#0369A1', 'on-info' => '#FFFFFF',
      ],
    ],
  ];
  /**
   * Maps old config key names to new config key names.
   *
   * Used during migration from the legacy 13-field color settings to the
   * current 22-field system. Keys not listed here (h2, h3, h4, color_scheme)
   * are discarded as they have no direct equivalent.
   */
  const LEGACY_KEY_MAP = [
    'tailpine_base_primary_color' => 'tailpine_color_primary',
    'tailpine_base_secondary_color' => 'tailpine_color_secondary',
    'tailpine_base_tertiary_color' => 'tailpine_color_tertiary',
    'tailpine_body_color' => 'tailpine_color_body',
    'tailpine_body_bg_color' => 'tailpine_color_body_bg',
    'tailpine_h1_color' => 'tailpine_color_heading',
    'tailpine_success_color' => 'tailpine_color_success',
    'tailpine_warning_color' => 'tailpine_color_warning',
    'tailpine_error_color' => 'tailpine_color_error',
  ];

  /**
   * All legacy config keys that should be removed after migration.
   */
  const LEGACY_KEYS = [
    'tailpine_base_primary_color',
    'tailpine_base_secondary_color',
    'tailpine_base_tertiary_color',
    'tailpine_body_color',
    'tailpine_body_bg_color',
    'tailpine_h1_color',
    'tailpine_h2_color',
    'tailpine_h3_color',
    'tailpine_h4_color',
    'tailpine_success_color',
    'tailpine_warning_color',
    'tailpine_error_color',
    'tailpine_color_scheme',
  ];

  /**
   * Migrates legacy color config keys to the new naming convention.
   *
   * Reads old keys from the active config, copies mapped values to new keys
   * (only if the new key is not already set), then removes all legacy keys.
   * Also performs a one-time reset of the stale Emerald defaults that were
   * seeded by the old config/install/tailpine.settings.yml.
   * This is safe to call repeatedly — it is a no-op once migration is done.
   */
  public static function migrateLegacyConfig(): void {
    $config = \Drupal::configFactory()
      ->getEditable('tailpine.settings');
    $data = $config->getRawData();
    $changed = FALSE;

    // -- Step 1: migrate legacy key names. ---------------------------------
    $has_legacy = FALSE;
    foreach (self::LEGACY_KEYS as $old_key) {
      if (array_key_exists($old_key, $data)) {
        $has_legacy = TRUE;
        break;
      }
    }

    if ($has_legacy) {
      // Copy mapped values to new keys (only if new key is empty/missing).
      foreach (self::LEGACY_KEY_MAP as $old_key => $new_key) {
        $old_value = $data[$old_key] ?? '';
        $new_value = $data[$new_key] ?? '';
        if ($old_value && !$new_value) {
          $config->set($new_key, $old_value);
        }
      }

      // Remove all legacy keys.
      foreach (self::LEGACY_KEYS as $old_key) {
        $config->clear($old_key);
      }

      $changed = TRUE;
    }

    // -- Step 2: one-time clear of stale seeded Emerald defaults. ----------
    // Old installs had Emerald hex values seeded via config/install. Clear
    // them so the form starts empty until the user picks colors explicitly.
    if (empty($data['tailpine_colors_reset_done'])) {
      foreach (array_keys(self::VARIABLES) as $var_name) {
        $config->set(self::getSettingKey($var_name), '');
      }
      $config->set('tailpine_colors_reset_done', TRUE);
      $changed = TRUE;
    }

    if ($changed) {
      $config->save();
    }
  }

  /**
   * Converts a CSS variable suffix to a Drupal config setting key.
   *
   * @param string $var_name
   *   The CSS variable suffix, e.g. 'primary-hover'.
   *
   * @return string
   *   The config key, e.g. 'tailpine_color_primary_hover'.
   */
  public static function getSettingKey(string $var_name): string {
    return 'tailpine_color_' . str_replace('-', '_', $var_name);
  }

  /**
   * Converts a CSS variable suffix to the full CSS custom property name.
   *
   * @param string $var_name
   *   The CSS variable suffix, e.g. 'primary-hover'.
   *
   * @return string
   *   The CSS custom property, e.g. '--t-primary-hover'.
   */
  public static function getCssVarName(string $var_name): string {
    return '--t-' . $var_name;
  }

  /**
   * Sanitizes a CSS color value to prevent injection.
   *
   * Allows hex (#abc, #aabbcc, #aabbccdd), rgb/rgba, and hsl/hsla values.
   * Returns an empty string for anything else.
   *
   * @param string $value
   *   The raw color value from the form.
   *
   * @return string
   *   The sanitized value, or empty string if invalid.
   */
  public static function sanitizeColorValue(string $value): string {
    $value = trim($value);
    if (preg_match('/^#([0-9a-fA-F]{3,8})$/', $value)) {
      return $value;
    }
    if (preg_match('/^rgba?\(\s*[\d.,\s%]+\)$/', $value)) {
      return $value;
    }
    if (preg_match('/^hsla?\(\s*[\d.,\s%deg]+\)$/', $value)) {
      return $value;
    }
    return '';
  }

  /**
   * Returns the THEMES array restructured for JavaScript consumption.
   *
   * Keys in the 'colors' sub-array use Drupal form field names
   * (tailpine_color_*) so the color-picker.js setColorScheme() function
   * can match them to input[name="..."] selectors.
   *
   * @return array
   *   Associative array keyed by theme machine name.
   */
  public static function getThemesForJs(): array {
    $result = [];
    foreach (self::THEMES as $key => $theme) {
      $js_colors = [];
      foreach ($theme['colors'] as $var_name => $hex) {
        $js_colors[self::getSettingKey($var_name)] = $hex;
      }
      $result[$key] = [
        'label' => $theme['label'],
        'colors' => $js_colors,
      ];
    }
    return $result;
  }

  /**
   * Returns the color map used by the frontend color switcher block.
   *
   * Each entry contains label, primary, secondary, and bg keys for
   * rendering swatch circles.
   *
   * @return array
   *   Associative array keyed by theme machine name.
   */
  public static function getSwatchMap(): array {
    $map = [];
    foreach (self::THEMES as $key => $theme) {
      $map[$key] = [
        'label' => $theme['label'],
        'primary' => $theme['colors']['primary'],
        'secondary' => $theme['colors']['secondary'],
        'bg' => $theme['colors']['body-bg'],
      ];
    }
    return $map;
  }

}
