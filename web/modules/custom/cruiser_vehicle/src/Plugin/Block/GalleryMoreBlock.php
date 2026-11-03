<?php

namespace Drupal\cruiser_vehicle\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\node\NodeInterface;

/**
 * "More from this category": latest projects in the current project's category.
 *
 * Shows nothing outside gallery projects or when the category has no others.
 */
#[Block(
  id: 'cruiser_gallery_more',
  admin_label: new TranslatableMarkup('Gallery: more from this category'),
  category: new TranslatableMarkup('Cruiser'),
)]
class GalleryMoreBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['heading' => 'More from this category', 'count' => 3];
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['heading'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Heading'),
      '#default_value' => $this->configuration['heading'],
    ];
    $form['count'] = [
      '#type' => 'number',
      '#title' => $this->t('Number of projects'),
      '#min' => 1,
      '#max' => 12,
      '#default_value' => $this->configuration['count'],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['heading'] = $form_state->getValue('heading');
    $this->configuration['count'] = (int) $form_state->getValue('count');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = ['#cache' => ['contexts' => ['route'], 'tags' => ['node_list:gallery']]];
    $node = \Drupal::routeMatch()->getParameter('node');
    if (!$node instanceof NodeInterface || !$node->hasField('field_gallery_category') || !function_exists('cruiserclassic_gallery_card')) {
      return $build;
    }
    $category = $node->get('field_gallery_category')->entity;
    if (!$category) {
      return $build;
    }
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()->accessCheck(TRUE)
      ->condition('type', 'gallery')
      ->condition('status', 1)
      ->condition('field_gallery_category', $category->id())
      ->condition('nid', $node->id(), '<>')
      ->sort('created', 'DESC')
      ->range(0, max(1, (int) $this->configuration['count']))
      ->execute();
    if (!$ids) {
      return $build;
    }
    $cards = [];
    foreach ($storage->loadMultiple($ids) as $other) {
      $cards[] = [
        '#type' => 'component',
        '#component' => 'cruiserclassic:gallery-card',
        '#props' => cruiserclassic_gallery_card($other),
      ];
    }
    $build['more'] = [
      '#type' => 'container',
      '#attributes' => ['class' => ['gallery-more', 'bg-body-bg', 'pb-[clamp(48px,6vw,96px)]']],
      'inner' => [
        '#type' => 'container',
        '#attributes' => ['class' => ['container', 'mx-auto', 'w-full', 'max-w-480']],
        'heading' => [
          '#type' => 'html_tag',
          '#tag' => 'h2',
          '#value' => $this->configuration['heading'],
          '#attributes' => ['class' => ['!mt-0', '!mb-[clamp(24px,3vw,40px)]', '!font-heading', 'uppercase']],
          '#access' => (string) $this->configuration['heading'] !== '',
        ],
        'grid' => [
          '#type' => 'container',
          '#attributes' => ['class' => ['grid', 'grid-cols-1', 'md:grid-cols-2', 'xl:grid-cols-3', 'gap-x-[clamp(16px,2vw,28px)]', 'gap-y-[clamp(20px,2.6vw,36px)]']],
        ] + $cards,
      ],
    ];
    return $build;
  }

}
