<?php

namespace Drupal\cruiser_vehicle\Controller;

use Drupal\Component\Utility\Html;
use Drupal\Core\Cache\CacheableJsonResponse;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Title suggestions for the vehicles search field.
 */
class VehicleAutocompleteController extends ControllerBase {

  /**
   * Returns up to 8 published vehicle titles containing the typed text.
   */
  public function title(Request $request): CacheableJsonResponse {
    $q = trim((string) $request->query->get('q'));
    $matches = [];

    if (mb_strlen($q) >= 2) {
      $storage = $this->entityTypeManager()->getStorage('node');
      $nids = $storage->getQuery()
        ->accessCheck(TRUE)
        ->condition('type', 'vehicle')
        ->condition('status', 1)
        ->condition('title', $q, 'CONTAINS')
        ->sort('title')
        ->range(0, 8)
        ->execute();
      foreach ($storage->loadMultiple($nids) as $node) {
        $matches[] = [
          'value' => $node->label(),
          'label' => Html::escape($node->label()),
        ];
      }
    }

    $response = new CacheableJsonResponse($matches);
    $response->addCacheableDependency(
      (new CacheableMetadata())
        ->setCacheContexts(['url.query_args:q'])
        ->setCacheTags(['node_list:vehicle'])
    );
    return $response;
  }

}
