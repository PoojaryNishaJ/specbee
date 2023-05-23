<?php

namespace Drupal\nishaj_exercise\EventSubscriber;  # defines the namespace for the event subscriber class.

use Symfony\Component\EventDispatcher\EventSubscriberInterface;  # implements EventSubscriberInterface.
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