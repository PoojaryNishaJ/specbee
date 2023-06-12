<?php

namespace Drupal\nishaj_exercise\Form;

// Defines the namespace for the form class.
use Drupal\Core\Form\ConfigFormBase;
// Imports the ConfigFormBase class.
use Drupal\Core\Form\FormStateInterface;

/**
 * Imports the FormStateInterface.
 */
class CustomConfigForm extends ConfigFormBase {
  // The CustomConfigForm class extends.
  // ConfigFormBase and defines the below methods.
  /**
   * Settings Variable.
   */
  const CONFIGNAME = "nishaj_exercise.settings";
  // The constant CONFIGNAME is declared.
  // With a value of "nishaj_exercise.settings".

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // GetFormId() method returns the ID of the form.
    return "nishaj_exercise_settings";
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    // Returns the name of the configuration objects.
    return [
      static::CONFIGNAME,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // The buildForm() method is used to build the form.
    $config = $this->config(static::CONFIGNAME);
    // Retrieves the configuration object for the configuration.
    // With the name specified in the CONFIGNAME constant.
    $form['fullname'] = [
          // Creates an array that defines the form element for the "fullname".
      '#type' => 'textfield',
           // Indicates text field.
      '#title' => ' <span>Name</span>',
          // Sets the label for the form element as "Name".
          // With the HTML <span> tag used to style the label.
      '#attached' => [
              // Attaches CSS library nishaj_exercise/css_lib to form element.
              // Which allows the styles defined in that library.
              // To be applied to the element.
        'library' => [
          'nishaj_exercise/css_lib',
        ],
      ],
      '#default_value' => $config->get("fullname"),
          // Sets the default value for the form element.
          // To the current value of the fullname.
    ];

    $form['email'] = [
          // A form element for email field.
      '#type' => 'email',
          // Field type for email.
      '#title' => 'Email',
          // Title for email.
      '#default_value' => $config->get("email"),
          // Get() method this means that.
          // If a value has been previously set for this field.
          // It will be pre-populated with that value when the form is loaded.
    ];

    $form['place'] = [
          // A form element for place field.
      '#type' => 'textfield',
          // Field type for place.
      '#title' => 'Place',
          // Field title for place.
      '#default_value' => $config->get("place"),
          // Get() method this means that if a value has been previously set.
          // For this field, it will be pre-populated.
          // With that value when the form is loaded.
    ];

    return parent::buildForm($form, $form_state);
    // The Parent::buildForm($form, $form_state).
    // Method is called to ensure that.
    // The parent class's buildForm() method is executed.
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // The submitForm method is used to handle the form submission.
    $config = $this->config(static::CONFIGNAME);
    $config->set("fullname", $form_state->getValue('fullname'));
    // Used to set the corresponding.
    // Configuration values using $config->set() for fullname.
    $config->set("email", $form_state->getValue('email'));
    // Used to set the corresponding.
    // Configuration values using $config->set() for email.
    $config->set("place", $form_state->getValue('place'));
    // Used to set the corresponding.
    // Configuration values using $config->set() for place.
    $config->save();
    // To save the configuration object.
  }

}
