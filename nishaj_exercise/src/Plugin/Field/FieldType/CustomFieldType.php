<?php

namespace Drupal\nishaj_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface;
// Field definition namespace.
use Drupal\Core\Form\FormStateInterface;
// Whenever there is form in drupal we call class FormStateInterface.
use Drupal\Core\TypedData\DataDefinition;

/**
 * Define the "custom field type".
 *
 * @FieldType(
 *   id = "custom_field_type",
 *   label = @Translation("Custom Field Type"),
 *   description = @Translation("Desc for Custom Field Type"),
 *   category = @Translation("Text"),
 * )
 */

/**
 * Above is the annotation to implement the plugin feature.
 */
class CustomFieldType extends FieldItemBase {

  /**
   * {@inheritdoc}
   */
  public static function schema(FieldStorageDefinitionInterface $field_definition) {
    // Schema is going to create a table in database.
    return [
      'columns' => [
        'value' => [
          'type' => 'varchar',
          'length' => $field_definition->getSetting("length"),
        ],
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultStorageSettings() {
    // Giving default value configurably giving the length of varchar field .
    return [
      'length' => 255,
    ] + parent::defaultStorageSettings();
    // When extending feature to use parent class(cardinality unlimited).
    // We are passing our field along with the existing field.
  }

  /**
   * {@inheritdoc}
   */
  public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) {
    // What ever the changes happen in database that will be included here .
    $element = [];
    $element['length'] = [
          // Mention for what the element is.
      '#type' => 'number',
      '#title' => t("Length of your text"),
      '#required' => TRUE,
      '#default_value' => $this->getSetting("length"),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultFieldSettings() {
    // Default field settings for the field type.
    return [
      'moreinfo' => "More info default value",
    ] + parent::defaultFieldSettings();
    // Requried, help text that all will be added.
  }

  /**
   * {@inheritdoc}
   */
  public function fieldSettingsForm(array $form, FormStateInterface $form_state) {
    // Whenever there is a change in node add and edit form.
    // That will be configured in this form.
    $element = [];
    $element['moreinfo'] = [
      '#type' => 'textfield',
      '#title' => 'More information about this field',
      '#required' => TRUE,
      '#default_value' => $this->getSetting("moreinfo"),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public static function propertyDefinitions(FieldStorageDefinitionInterface $field_definition) {
    // The properties of the field type type of field and label for it.
    $properties['value'] = DataDefinition::create('string')->setLabel(t("Name"));
    return $properties;
  }

}
