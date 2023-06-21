<?php

namespace Drupal\nishaj_exercise\EventSubscriber;

use Drupal\Core\Database\Connection;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\nishaj_exercise\Event\UserLoginEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Drupal\Core\Datetime\DateFormatterInterface;

/**
 * Class UserLoginSubscriber.
 *
 * @package Drupal\nishaj_exercise\EventSubscriber
 */
class CustomConfigEventsSubscriber implements EventSubscriberInterface {

  /**
   * The database connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

   /**
   * The messenger service.
   *
   * @var \Drupal\Core\Datetime\DateFormatterInterface
   */
  protected $dateFormatter;

  /**
   * CustomConfigEventsSubscriber constructor.
   *
   * @param \Drupal\Core\Database\Connection $database
   *   The database connection.
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Datetime\DateFormatterInterface $dateFormatter
   *   The date formatter service.
   */
  public function __construct(Connection $database, MessengerInterface $messenger, DateFormatterInterface $dateFormatter) {
    $this->database = $database;
    $this->messenger = $messenger;
    $this->dateFormatter = $dateFormatter;
  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    return [
      /* Static class constant => method on this class. */
      UserLoginEvent::EVENT_NAME => 'onUserLogin',
    ];
  }

  /**
   * Subscribe to the user login event dispatched.
   *
   * @param \Drupal\nisha_exercise\Event\UserLoginEvent $event
   *   Our custom event object.
   */
  public function onUserLogin(UserLoginEvent $event) {
    // Selecting the table from db.
    $account_created = $this->database->select('users_field_data', 'ud')
      // Returns when the account was created.
      ->fields('ud', ['created'])
      // Returns the userid.
      ->condition('ud.uid', $event->account->id())
      ->execute()
      ->fetchField();

    // Using message service to get message whenever user logs in.
    $this->messenger->addStatus(t('Welcome to the site, your account was created on %created_date.', [
      '%created_date' => $this->dateFormatter->format($account_created, 'long'),
    ]));
  }

}