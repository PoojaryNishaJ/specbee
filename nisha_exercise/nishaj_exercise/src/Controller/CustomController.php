<?php

namespace Drupal\nishaj_exercise\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\nishaj_exercise\CustomService;

/**
 * Custom Controller class.
 */
class CustomController extends ControllerBase {

  /**
   * The custom service instance.
   *
   * @var \Drupal\nishaj_exercise\CustomService
   */
  protected $customService;

  /**
   * CustomController constructor.
   *
   * @param \Drupal\nishaj_exercise\CustomService $customService
   *   The custom service instance.
   */
  public function __construct(CustomService $customService) {
    $this->customService = $customService;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('nishaj_exercise.custom_service')
    );
  }

  /**
   * This method gets called when the route is matched.
   */
  public function hello() {
    $data = $this->customService->getName();
    return [
      '#theme' => 'block_plugin_template',
      '#text' => $data,
      '#hexcode' => '#800080',
    ];
  }

  public function modalLink() {
    $build['#attached']['library'][] = 'core/drupal.dialog.ajax'; //dependent library for modal window.
    $build = [
      '#markup' => '<a href="/drupal-10.0.4/admin/config/example-form" class="use-ajax" data-dialog-type="modal">Click here</a>',
    ];
    return $build;
  }

}
