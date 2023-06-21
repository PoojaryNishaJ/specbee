<?php

namespace Drupal\nishaj_exercise\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Messenger\MessengerInterface;
use Drupal\Core\Database\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\InvokeCommand;

/**
 * Form Interactions.
 */
class CustomForm extends FormBase {

  /**
   * The messenger service.
   *
   * @var \Drupal\Core\Messenger\MessengerInterface
   */
  protected $messenger;

  /**
   * The database service.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * CustomForm constructor.
   *
   * @param \Drupal\Core\Messenger\MessengerInterface $messenger
   *   The messenger service.
   * @param \Drupal\Core\Database\Connection $database
   *   The database service.
   */
  public function __construct(MessengerInterface $messenger, Connection $database) {
    $this->messenger = $messenger;
    $this->database = $database;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('messenger'),
      $container->get('database')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_form_user_details';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['firstname'] = [
      '#type' => 'textfield',
      '#title' => 'First Name',
      '#required' => TRUE,
      '#placeholder' => 'First Name',
    ];
    $form['email'] = [
      '#type' => 'textfield',
      '#title' => 'Email',
    ];
    $form['gender'] = [
      '#type' => 'select',
      '#title' => 'Gender',
      '#options' => [
        'male' => 'Male',
        'female' => 'Female',
      ],
    ];
    $form['permanent_address'] = array(
    '#type' => 'checkbox',
    '#title' => t('Permanent Address'),
    '#attributes' => array('class' => array('address-checkbox')),
  );

  $form['temporary_address'] = array(
    '#type' => 'checkbox',
    '#title' => t('Temporary Address'),
    '#attributes' => array('class' => array('address-checkbox')),
  );


  $form['#attached']['library'][] = "nishaj_exercise/custom";
  $form['#attached']['drupalSettings']['nisha_exercise'] = array(
    'addressCheckboxClass' => 'address-checkbox',
  );
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
      '#ajax'=> [
        'callback' => '::setAjaxSubmit',
      ],
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function setAjaxSubmit() {
    $response = new AjaxResponse();
    $response->addCommand(new InvokeCommand("html", 'datacheck'));
    return $response;
  }
  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    if (strlen($form_state->getValue('firstname')) < 3) {
      $form_state->setErrorByName('firstname', $this->t('Too less content'));
    }
      $email = $form_state->getValue('email');
      if (!preg_match('[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}', $email)) {
        $form_state->setErrorByName('email', $this->t('Invalid email format'));
      }
  }
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->messenger->addMessage("User Details Submitted Successfully");
    $this->database->insert("user_details")->fields([
      'firstname' => $form_state->getValue("firstname"),
      'email' => $form_state->getValue("email"),
      'gender' => $form_state->getValue("gender"),
    ])->execute();
  }

}