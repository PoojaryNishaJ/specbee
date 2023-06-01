<?php

namespace Drupal\nishaj_exercise\Event;

use Drupal\Component\EventDispatcher\Event;  # included the class name event.
use Drupal\user\UserInterface;

/**
 * Event that is fired when a user logs in.
 */
class UserLoginEvent extends Event {

  // This makes it easier for subscribers to reliably use our event name.
const EVENT_NAME = 'custom_events_user_login'; # name of the event.The event get dispatched when the user get logged in into the system.

/**
   * The user account.
   *
   * @var \Drupal\user\UserInterface
   */
public $account;  # using the current user account.

/**
   * Constructs the object.
   *
   * @param \Drupal\user\UserInterface $account
   *   The account of the user logged in.
   */
public function __construct(UserInterface $account) { # from the dispatch function we will be passing the account object here and set.
    $this->account = $account;
}

}