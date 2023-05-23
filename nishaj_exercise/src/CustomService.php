<?php

namespace Drupal\nishaj_exercise;

use Drupal\Core\Config\ConfigFactory;    # The service accepts a "ConfigFactory" object as a dependency, which is injected via the constructor.

/**
 * Class CustomService.
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
   * Constructor.
   */
    public function __construct(ConfigFactory $configFactory) {
    $this->configFactory = $configFactory;  # The "ConfigFactory" object is a Drupal core service that provides a way to load and manipulate configuration data.
    }

/**
   * Gets my setting.
   */
  public function getName() {            # The value of the "fullname" configuration setting is returned by the method
    $config = $this->configFactory->get('nishaj_exercise.settings');
    return $config->get('fullname');
  }

}