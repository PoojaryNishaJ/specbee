<?php

namespace Drupal\nishaj_exercise\Controller;

// Defines the namespace for the controller.
// Imports the ControllerBase class from the "Drupal\Core\Controller" namespace.
// This allows us to extend the ControllerBase class in our custom controller.
use Drupal\Core\Controller\ControllerBase;

/**
 * Custom Controller class.
 */
class CustomController extends ControllerBase {

  /**
   * This method gets called when the route is matched.
   */
  public function hello() {
    // getName() method to retrieve data.
    // And Drupal service container called to get an instance of custom service.
    $data = \Drupal::service("custom_service")->getName();
    return [
          // The theme to be rendered.
      '#theme' => "block_plugin_template",
          // Variables.
      '#text' => $data,
      '#hexcode' => '#800080',
    ];

  }

}
