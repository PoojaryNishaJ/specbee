<?php

namespace Drupal\nishaj_exercise\Form;    # defines the namespace for the form class.

use Drupal\Core\Form\FormBase;            # The FormBase class is the base class for forms
use Drupal\Core\Form\FormStateInterface;  # The FormStateInterface interface provides a way to interact with the state of the form during processing and validation.

class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {             # sets the unique ID of the form
    return 'dependent_dropdown_form';       # The ID is set to 'custom_form_user_details'.
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {         # used to build the form.
    $countries = static::getCountries();  #  fetch the list of countries static::getCountries() will call the getCountries() method defined in the DependentDropdownForm class.
    $defaultCountry = $form_state->getValue('country') ?? 'none';  # set the default value for the Country dropdown based on the previously selected value or 'none' if no value is available.

    $form['country'] = [     #sets up the Country dropdown element in the form
      '#type' => 'select',    #specifies that the form element is a dropdown/select list.
      '#title' => 'Country',
      '#options' => $countries,   #assigns the array of country options (retrieved from the getCountries() method) to the dropdown options. This array will be used to populate the available options in the dropdown.
      '#default_value' => $defaultCountry,  #sets the default value for the dropdown to the previously selected value (retrieved from the form state) or 'none' if no value is available.
      '#ajax' => [
        'callback' => '::updateStatesDropdown', # triggers the updateStatesDropdown() method when the dropdown value is changed.
        'wrapper' => 'states-container',   #The updated content will be loaded into the HTML element with the ID 'states-container'.
        'event' => 'change',
      ],
    ];

    $selectedCountry = $form_state->getValue('country') ?? $defaultCountry;  #retrieves the value of the 'country' form element from the form state
    $states = static::getStates($selectedCountry);#calls the getStates() method, passing the selected country value ($selectedCountry) as the argument. getStates() method will return an array of states based on the selected country.
    $defaultState = $form_state->getValue('state') ?? '';  #checks selected state value.

    $form['states_container'] = [   # the container is likely used to wrap the State dropdown and its related elements, such as the label or any validation messages, and provide a target wrapper for AJAX updates.
      '#type' => 'container',
      '#attributes' => ['id' => 'states-container'],
    ];

    $form['states_container']['state'] = [   # adds the State dropdown element
      '#type' => 'select',      #This line sets the element type of the State dropdown to 'select'.
      '#title' => 'State',    #sets the title or label for the State dropdown
      '#options' => $states,   #sets the available options for the State dropdown
      '#default_value' => $defaultState,  #sets the default value for the State dropdown
      '#ajax' => [      #sets up AJAX functionality for the State dropdown
        'callback' => '::updateDistrictsDropdown',
        'wrapper' => 'states-district-container',
        'event' => 'change',
      ],
    ];

    $selectedState = $form_state->getValue('state') ?? $defaultState; # retrieves the selected state value from the form state
    $districts = static::getDistricts($selectedState);   #fetches the districts associated with that state.
    $defaultDistrict = $form_state->getValue('district') ?? '';  #retrieves the district value from the form state

    $form['states_district_container'] = [  # to group the District dropdown
      '#type' => 'container',
      '#attributes' => ['id' => 'states-district-container'],
    ];

    $form['states_district_container']['district'] = [  # adds the district dropdown element
      '#type' => 'select',                              #This line sets the element type of the District dropdown to 'select'.
      '#title' => 'District',                            #sets the title or label
      '#options' => $districts,                        #sets the available option
      '#default_value' => $defaultDistrict,           #sets the default value
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
