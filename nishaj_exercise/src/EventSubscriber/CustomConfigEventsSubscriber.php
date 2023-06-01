<?php

namespace Drupal\nishaj_exercise\EventSubscriber;  # defines the namespace for the event subscriber class.

use Symfony\Component\EventDispatcher\EventSubscriberInterface;  # implements EventSubscriberInterface.
use Drupal\nishaj_exercise\Event\UserLoginEvent;
use Drupal\Core\Config\ConfigEvents;
use Drupal\Core\Config\ConfigCrudEvent;

class CustomConfigEventsSubscriber implements EventSubscriberInterface {  # class will be automatically instantiated and its event handling methods will be called when the corresponding events will be triggered.
    /**
   * {@inheritdoc}
   *
   * @return array
   */
public static function getSubscribedEvents() {   # define that the particular event is subscribing to which event.
    $events[ConfigEvents::SAVE][] = ['configSave', -100];  # The class subscribes to two events from the ConfigEvents class: SAVE and DELETE  (setting priorities -100 -> lowest priority)
    $events[ConfigEvents::SAVE][] = ['configDelete', 100]; # (setting priorities -100 -> highest priority)
    return $events;
    }

    public function configSave(ConfigCrudEvent $event) {  # whenever the configuration is get saved this function will get called.
        $config = $event->getConfig(); # getting the configuration object from that config object we are getting the name,
        \Drupal::messenger()->addStatus('Saved config: ' . $config->getName());  # which configuration we are saving for that configuration name will be fetched and displayed.
    }

    public function configDelete(ConfigCrudEvent $event) {  # whenever the configuration is get deleted this function will get called.
        $config = $event->getConfig();                      # getting the configuration object from that config object we are getting the name,
        \Drupal::messenger()->addStatus('Deleted config: ' . $config->getName());  # which configuration we are deleting for that configuration name will be fetched and displayed.
    }

}

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\nishaj_exercise\EventSubscriber
 */
class UserLoginSubscriber implements EventSubscriberInterface {

/**
   * {@inheritdoc}
   */
public static function getSubscribedEvents() {  # mention the event name which we rae going to use.
    return [
      // Static class constant => method on this class.
    UserLoginEvent::EVENT_NAME => 'onUserLogin', # whenever the event get dispatched the function will be get called.
    ];
}

/**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\custom_events\Event\UserLoginEvent $event
   *   Our custom event object.
   */
public function onUserLogin(UserLoginEvent $event) { # whenever the event get dispatched the function will be get called.
    $database = \Drupal::database();  # Initializing the database service
    $dateFormatter = \Drupal::service('date.formatter'); # Initialized date formatter

    $account_created = $database->select('users_field_data', 'ud') # fetching the user information
        ->fields('ud', ['created'])  # passing the user id as condition and getting the created fields.
        ->condition('ud.uid', $event->account->id())# we can get the account information in the event object.
        ->execute()
        ->fetchField();
    \Drupal::messenger()->addStatus(t('Welcome, your account was created on %created_date.', [  #Displalying the events
        '%created_date' => $dateFormatter->format($account_created, 'short'),
    ]));
    }

}