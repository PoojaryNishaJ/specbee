<?php

namespace Drupal\dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\node\Entity\Node;
use Drupal\Core\Database\Database;


class CountryStateDistrictForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'country_state_district_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
        $selected_country_id=$form_state->getValue("countries");
        $selected_state_id=$form_state->getValue("states");
    $form['countries'] = [
      '#type' => 'select',
      '#title' => $this->t('Countries'),
      '#options' => $this->getCountryOptions(),
      '#empty_option' => $this->t('-- Select --'),
      '#ajax' => [
        'callback' => [$this, 'ajaxStateDropdownCallback'],
        'wrapper' => 'state-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
        ],
      ],
    ];

    $form['states'] = [
      '#type' => 'select',
      '#title' => $this->t('States'),
      '#options' => $this->getstateOptions( $selected_country_id),
      '#prefix' => '<div id="state-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('--Select --'),
      '#disabled' => FALSE,
      '#ajax' => [
        'callback' => [$this, 'ajaxDistrictDropdownCallback'],
        'wrapper' => 'district-dropdown-wrapper',
        'event' => 'change',
        'progress' => [
          'type' => 'throbber',
        ],
      ],
    ];

    $form['districts'] = [
      '#type' => 'select',
      '#title' => $this->t('Districts'),
      '#options' => $this->getDistrictsByState($selected_state_id),
      '#prefix' => '<div id="district-dropdown-wrapper">',
      '#suffix' => '</div>',
      '#empty_option' => $this->t('-- Select --'),
      '#disabled' => FALSE,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Handle form submission if needed.
  }

  /**
   * Ajax callback for the state dropdown.
   */
  public function ajaxStateDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['states'];
  }

  /**
   * Ajax callback for the district dropdown.
   */
  public function ajaxDistrictDropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['districts'];
  }

  /**
   * Helper function to retrieve country options.
   */
  private function getCountryOptions() {
    $query = Database::getConnection()->select('countries', 'c');
    $query->fields('c', ['id', 'name']);
    $result = $query->execute();
    $options = [];

    foreach ($result as $row) {
      $options[$row->id] = $row->name;
    }

    return $options;
  }
  private function getstateOptions( $selected_country_id){

    // Fetch the states for the selected country
    $query = Database::getConnection()->select('states', 's');
    $query->fields('s', ['id', 'name']);
    $query->condition('s.country_id',  $selected_country_id);
    $result = $query->execute();

    // Iterate over the result to retrieve the state information
    $states = [];
    foreach ($result as $row) {
      $states[$row->id] = $row->name;
    }
    return $states;
  }

  function getDistrictsByState( $selected_state_id) {
    $query = Database::getConnection()->select('districts', 'd');
    $query->fields('d', ['id', 'name']);
    $query->condition('d.state_id', $selected_state_id);
    $result = $query->execute();

    $districts = [];
    foreach ($result as $row) {
      $districts[$row->id] = $row->name;
    }

    return $districts;
  }
}