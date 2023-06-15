<?php

namespace Drupal\nishaj_exercise\Form;

// Defines the namespace for the form class.
use Drupal\Core\Form\FormBase;
// The FormBase class is the base class for forms.
use Drupal\Core\Form\FormStateInterface;

// FormStateInterface interface provides way to interact.
// With the state of the form during processing and validation.
/**
 * Form Interactions.
 */
class CustomForm extends FormBase {

  /**
   * Gets form id.
   */
  public function getFormId() {
    // Sets the unique ID of the form.
    return 'custom_form_user_details';
    // The ID is set to 'custom_form_user_details'.
  }

  /**
   * Builds generic form.
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Used to build the form.
    // Input fields.
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
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];
    return $form;

  }

  /**
   * Handles the form submission.
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // To handle the form submission.
    \Drupal::messenger()->addMessage("User Details Submitted Successfully");
    \Drupal::database()->insert("user_details")->fields([
          // Used to initialize the  database service.
      'firstname' => $form_state->getValue("firstname"),
          // Used to get the first name value.
      'email' => $form_state->getValue("email"),
          // Used to get the email value.
      'gender' => $form_state->getValue("gender"),
          // Used to get the gender value.
    ])->execute();

  }

}
