<?php

// Defines the namespace for the event subscriber class.
namespace Drupal\nishaj_exercise\EventSubscriber;

// Implements EventSubscriberInterface.
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
// The UserLoginEvent that we have created.
use Drupal\nishaj_exercise\Event\UserLoginEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;

/**
 * Class will be automatically instantiated.
 */
class CustomConfigEventsSubscriber implements EventSubscriberInterface {
  // Class will be automatically instantiated.
  // And its event handling methods will be called.
  // When the corresponding events will be triggered.

  /**
   * {@inheritdoc}
   *
   * @return array
   *   Defines event.
   */
  public static function getSubscribedEvents() {
    // Defines the particular event is.
    // Subscribing to which event.
    // The class subscribes to two events from the.
    // ConfigEvents class: SAVE and.
    // DELETE  (setting priorities -100 -> lowest priority).
    $events[ConfigEvents::SAVE][] = ['configSave', -100];
    // (setting priorities -100 -> highest priority)
    $events[ConfigEvents::SAVE][] = ['configDelete', 100];
    return $events;
  }

  /**
   * Whenever the configuration is get saved this function will get called.
   */
  public function configSave(ConfigCrudEvent $event) {
    // Whenever the configuration is get saved this function will get called.
    // Getting the configuration object.
    // From that config object we are getting the name.
    $config = $event->getConfig();
    // Which configuration we are saving.
    // for that configuration name will be fetched and displayed.
    \Drupal::messenger()->addStatus('Saved config: ' . $config->getName());
  }

  /**
   * Whenever the configuration is get deleted this function will get called.
   */
  public function configDelete(ConfigCrudEvent $event) {
    // Whenever the configuration is get deleted this function will get called.
    // Getting the configuration object.
    // from that config object we are getting the name,.
    $config = $event->getConfig();
    // Which configuration we are deleting for that.
    // Configuration name will be fetched and displayed.
    \Drupal::messenger()->addStatus('Deleted config: ' . $config->getName());
  }

}

/**
 * Class to implement the event subscriber.
 *
 * @package Drupal\nishaj_exercise\EventSubscriber
 */
class UserLoginSubscriber implements EventSubscriberInterface {

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    // Mention the event name which we are going to use in this file.
    return [
      // Static class constant => method on this class.
    // Whenever the event get dispatched the function will be get called.
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\UserLoginEvent $event
   *   Our custom event object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    // Whenever the event get dispatched the function will be get called.
    // Initializing the database service.
    $database = \Drupal::database();
    // Initialized date formatter.
    $dateFormatter = \Drupal::service('date.formatter');

    // Fetching the user information.
    $account_created = $database->select('users_field_data', 'ud')
    // Passing the user id as condition and getting the created fields.
      ->fields('ud', ['created'])
    // We can get the account information in the event object.
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();
    // Displalying the events.
    \Drupal::messenger()->addStatus(t('Welcome, your account was created on %created_date.', [
      '%created_date' => $dateFormatter->format($account_created, 'short'),
    ]));
  }

}
