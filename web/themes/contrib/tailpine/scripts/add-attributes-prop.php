<?php

/**
 * @file
 * Adds the 'attributes' prop to component.yml files that are missing it.
 *
 * Run from Drupal root:
 * ddev exec php web/themes/contrib/tailpine/scripts/add-attributes-prop.php.
 */

$theme_root = __DIR__ . '/..';
$files = [];
$iterator = new RecursiveIteratorIterator(
  new RecursiveDirectoryIterator($theme_root . '/components')
);
foreach ($iterator as $file) {
  if ($file->isFile() && str_ends_with($file->getFilename(), '.component.yml')) {
    $files[] = $file->getPathname();
  }
}

$attributes_block = <<<'YAML'
    attributes:
      type: Drupal\Core\Template\Attribute
      title: HTML attributes
      description: Additional HTML attributes.
YAML;

$added = 0;
$skipped = 0;

foreach ($files as $file) {
  $content = file_get_contents($file);

  // Error handling for file read failures.
  if ($content === FALSE) {
    echo "  ERROR: could not read $file\n";
    continue;
  }

  // Skip if attributes prop already declared.
  if (strpos($content, 'type: Drupal\Core\Template\Attribute') !== FALSE) {
    $skipped++;
    continue;
  }

  // Skip if no props.properties section present.
  if (!preg_match('/^props:\n  type: object\n  properties:/m', $content)) {
    $skipped++;
    continue;
  }

  // Insert attributes block immediately after the
  // 'props:\n  type: object\n  properties:' line.
  $new_content = preg_replace(
    '/^(props:\n  type: object\n  properties:)$/m',
    "$1\n" . $attributes_block,
    $content,
    1
  );

  if ($new_content === $content) {
    echo "  WARNING: regex matched guard but replacement produced no change: " . str_replace($theme_root . '/', '', $file) . "\n";
    $skipped++;
    continue;
  }

  $result = file_put_contents($file, $new_content);
  if ($result === FALSE) {
    echo "  ERROR: could not write $file\n";
    continue;
  }

  $added++;
  echo "  Added attributes to: " . str_replace($theme_root . '/', '', $file) . "\n";
}

echo "\nDone. Added: $added, Skipped: $skipped\n";
