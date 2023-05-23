<?php

namespace Drupal\nishaj_exercise\Controller;       # defines the namespace for the controller

use Drupal\Core\Controller\ControllerBase;         # imports the ControllerBase class from the "Drupal\Core\Controller" namespace. This allows us to extend the ControllerBase class in our custom controller.

class CustomController extends ControllerBase {

    public function hello() {                      # This method gets called when the route is matched.
    $data=\Drupal::service("custom_service")->getName();    # getName() method to retrieve data and Drupal service container is called to get an instance of custom service.
        return[
            '#theme' => "block_plugin_template",   # The theme to be rendered.
            '#text' =>  $data,                     # variables
            '#hexcode' =>'#800080',
    ];

    }


}