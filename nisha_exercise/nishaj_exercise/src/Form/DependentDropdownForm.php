<?php

namespace Drupal\nishaj_exercise\Form;

// Defines the namespace for the form class.
use Drupal\Core\Form\FormBase;
// The FormBase class is the base class for forms.
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Connection;

// FormStateInterface interface provides way to interact.
// With the state of the form during processing and validation.
/**
 * Form Interactions.
 */
class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    // Sets the unique ID of the form.
    return 'dependent_dropdown_form';
    // The ID is set to 'custom_form_user_details'.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    // Used to build the form.
    $countries = static::getCountries();
    // Fetch the list of countries static::getCountries()
    // Will call the getCountries() method
    // Defined in the DependentDropdownForm class.
    $defaultCountry = $form_state->getValue('country') ?? 'none';
    // Set the default value for the Country dropdown
    // Based on the previously selected value or none if no value is available.
    $form['country'] = [
      // Sets up the Country dropdown element in the form.
      '#type' => 'select',
      // Specifies that the form element is a dropdown/select list.
      '#title' => 'Country',
      '#options' => $countries,
      // Assigns the array of country
      // Options(retrieved from getCountries() method) to dropdown options.
      // This array will be used to populate the available options in dropdown.
      '#default_value' => $defaultCountry,
      // Sets the default value for the dropdown
      // To the previously selected value(retrieved from the form state).
      // Or none if no value is available.
      '#ajax' => [
        'callback' => '::updateStatesDropdown',
        // Triggers this method when dropdown value changes.
        'wrapper' => 'states-container',
        // The updated content will be loaded into the HTML element.
        // With the ID 'states-container'.
        'event' => 'change',
      ],
    ];

    $selectedCountry = $form_state->getValue('country') ?? $defaultCountry;
    // Retrieves the value of the 'country' form element from the form state.
    $states = static::getStates($selectedCountry);
    // Calls this method passes the selected country value ($selectedCountry).
    // As the argument getStates() method will return.
    // An array of states based on the selected country.
    $defaultState = $form_state->getValue('state') ?? '';
    // Checks selected state value.
    $form['states_container'] = [
      // The container is likely used to wrap the State dropdown.
      // And its related elements, such as the label or any validation messages.
      // And provide a target wrapper for AJAX updates.
      '#type' => 'container',
      '#attributes' => ['id' => 'states-container'],
    ];

    $form['states_container']['state'] = [
      // Adds the State dropdown element.
      '#type' => 'select',
      // This line sets the element type of the State dropdown to 'select'.
      '#title' => 'State',
      // Sets the title or label for the State dropdown.
      '#options' => $states,
      // Sets the available options for the State dropdown.
      '#default_value' => $defaultState,
      // Sets the default value for the State dropdown.
      '#ajax' => [
        // Sets up AJAX functionality for the State dropdown.
        'callback' => '::updateDistrictsDropdown',
        'wrapper' => 'states-district-container',
        'event' => 'change',
      ],
    ];

    $selectedState = $form_state->getValue('state') ?? $defaultState;
    // Retrieves the selected state value from the form state.
    $districts = static::getDistricts($selectedState);
    // Fetches the districts associated with that state.
    $defaultDistrict = $form_state->getValue('district') ?? '';
    // Retrieves the district value from the form state.
    // To group the District dropdown.
    $form['states_district_container'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'states-district-container'],
    ];

    $form['states_district_container']['district'] = [
      // Adds the district dropdown element.
      '#type' => 'select',
      // This line sets the element type of the District dropdown to 'select'.
      '#title' => 'District',
      // Sets the title or label.
      '#options' => $districts,
      // Sets the available option.
      '#default_value' => $defaultDistrict,
      // Sets the default value.
    ];

    $form['submit'] = [
      '#type' => 'submit',
      '#value' => 'Submit',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Submit form logic goes here.
  }

  /**
   * AJAX callback to update the states dropdown based on the selected country.
   */
  public function updateStatesDropdown(array &$form, FormStateInterface $form_state) {
    return $form['states_container'];
  }

  /**
   * The district will be updated.
   */
  public function updateDistrictsDropdown(array &$form, FormStateInterface $form_state) {
    return $form['states_district_container'];
  }

  /**
   * Get the list of countries.
   */
  public function getCountries() {
    return [
      'none' => '- Select Country -',
      'in' => 'India',
      'us' => 'United States',
      'uk' => 'United Kingdom',
    ];
  }

  /**
   * Get the states based on the selected country.
   */
  public function getStates($country) {
    switch ($country) {
      case 'in':
        $states = [
          'none' => '- Select State -',
          'ka' => 'Karnataka',
          'ma' => 'Maharashtra',
          'tn' => 'Tamil Nadu',
        ];
        break;

      case 'us':
        $states = [
          'none' => '- Select State -',
          'ny' => 'New York',
          'ca' => 'California',
          'tx' => 'Texas',
        ];
        break;

      case 'uk':
        $states = [
          'none' => '- Select Region -',
          'eng' => 'England',
          'sco' => 'Scotland',
          'wal' => 'Wales',
        ];
        break;

      default:
        $states = ['none' => '- Select State -'];
        break;
    }

    return $states;
  }

  /**
   * Get the districts based on the selected state.
   */
  public function getDistricts($state) {
    switch ($state) {
      case 'ka':
        $districts = [
          'none' => '- Select District -',
          'blr' => 'Dakshina Kannada',
          'mng' => 'Madikeri',
          'mys' => 'Mysore',
        ];
        break;

      case 'ma':
        $districts = [
          'none' => '- Select District -',
          'mum' => 'Mumbai',
          'pune' => 'Pune',
          'nag' => 'Nagpur',
        ];
        break;

      case 'tn':
        $districts = [
          'none' => '- Select District -',
          'chn' => 'Chennai',
          'coi' => 'Coimbatore',
          'mdr' => 'Madurai',
        ];
        break;

      default:
        $districts = ['none' => '- Select District -'];
        break;
    }

    return $districts;
  }

}
