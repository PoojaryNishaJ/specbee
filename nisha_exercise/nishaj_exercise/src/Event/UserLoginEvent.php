<?php

namespace Drupal\nishaj_exercise\Event;

// Included the class name event.
use Drupal\Component\EventDispatcher\Event;
use Drupal\user\UserInterface;

/**
 * Event that is fired when a user logs in.
 */
class UserLoginEvent extends Event {

  // This makes it easier for subscribers to reliably use our event name.
  // Name of the event.The event get dispatched.
  // When the user get logged in into the system.
  const EVENT_NAME = 'custom_events_user_login';

  /**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   *   This is the user interface.
   */
  public $account;

  /**
   * Constructs the object.
   *
   * @param \Drupal\user\UserInterface $account
   *   The account of the user logged in.
   */

  /**
   * From the dispatch function we will pass the account object here and set.
   */
  public function __construct(UserInterface $account) {

    $this->account = $account;
  }

}
