<?php

namespace Drupal\cruiser_vehicle\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\node\NodeInterface;

/**
 * Photo gallery for the current node: main/cover image first, then its photos.
 *
 * Vehicles: field_vehicle_photos (shows nothing without extra photos).
 * Gallery projects: field_gallery_photos (always shows, cover alone is fine).
 */
#[Block(
  id: 'cruiser_vehicle_gallery',
  admin_label: new TranslatableMarkup('Photo gallery (vehicle / gallery project)'),
  category: new TranslatableMarkup('Cruiser'),
)]
class VehicleGalleryBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#cache' => ['contexts' => ['route']]];
    $node = \Drupal::routeMatch()->getParameter('node');
    $field = match (TRUE) {
      $node instanceof NodeInterface && $node->hasField('field_vehicle_photos') => 'field_vehicle_photos',
      $node instanceof NodeInterface && $node->hasField('field_gallery_photos') => 'field_gallery_photos',
      default => NULL,
    };
    if (!$field) {
      return $build;
    }
    $build['#cache']['tags'] = $node->getCacheTags();
    $extra = $node->get($field)->referencedEntities();
    if (!$extra && $field === 'field_vehicle_photos') {
      return $build;
    }
    $photos = [];
    $media = array_merge(array_filter([$node->get('field_image')->entity]), $extra);
    foreach ($media as $item) {
      $image = $item->hasField('field_media_image') ? $item->get('field_media_image')->first() : NULL;
      if ($image && $image->entity) {
        $photos[] = [
          'src' => \Drupal::service('file_url_generator')->generateString($image->entity->getFileUri()),
          'alt' => $image->alt ?: $node->label(),
        ];
        $build['#cache']['tags'] = Cache::mergeTags($build['#cache']['tags'], $item->getCacheTags());
      }
    }
    $build['gallery'] = [
      '#type' => 'component',
      '#component' => 'cruiserclassic:photo-gallery',
      '#props' => ['photos' => $photos],
    ];
    return $build;
  }

}
