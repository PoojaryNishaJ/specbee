<?php

namespace Drupal\nishaj_exercise;

use Drupal\Core\Config\ConfigFactory;

// The service accepts a "ConfigFactory" object as a dependency.
// Which is injected via the constructor.

/**
 * Service class.
 *
 * @package Drupal\nishaj_exercise\Services
 */
class CustomService {

  /**
   * Configuration Factory.
   *
   * @var \Drupal\Core\Config\ConfigFactory
   */
  protected $configFactory;

  /**
   * Provides a way to load and manipulate configuration data.
   */
  public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;
    // The "ConfigFactory" object is a Drupal core service.
    // That provides a way to load and manipulate configuration data.
  }

  /**
   * Gets my setting.
   */
  public function getName() {
    // The value of fullname configuration setting is returned by the method.
    $config = $this->configFactory->get('nishaj_exercise.settings');
    return $config->get('fullname');
  }

}



