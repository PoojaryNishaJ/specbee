<?php

namespace Drupal\nishaj_exercise\Plugin\Field\FieldType;

use Drupal\Core\Field\FieldItemBase;
use Drupal\Core\Field\FieldStorageDefinitionInterface; # field definition namespace.
use Drupal\Core\Form\FormStateInterface;  # whenever there is form in drupal we call the class FormStateInterface.
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

#Above isthe annotation to implement the plugin feature.
class CustomFieldType extends FieldItemBase {

    /**
     * {@inheritdoc}
     */

    public static function schema(FieldStorageDefinitionInterface $field_definition) {  # schema is going to create a table in database.
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
    public static function defaultStorageSettings() { # giving default value, configurably giving the length of the varchar field .
        return [
            'length' => 255,
        ] + parent::defaultStorageSettings();  # when you are extending the feature we have to use parent class. We are passing our field along with the existing field.
    }

    /**
     * {@inheritdoc}
     */
    public function storageSettingsForm(array &$form, FormStateInterface $form_state, $has_data) { # the changes in the database.
        $element = [];

        $element['length'] = [
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
    public static function defaultFieldSettings() { # default field settings for the field type.
        return [
            'moreinfo' => "More info default value",
        ] + parent::defaultFieldSettings();
    }

    /**
     * {@inheritdoc}
     */
    public function fieldSettingsForm(array $form, FormStateInterface $form_state) { # the changes in node add and edit form.
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
    public static function PropertyDefinitions(FieldStorageDefinitionInterface $field_definition) {  #  the properties of the field type.
        $properties['value'] = DataDefinition::create('string')->setLabel(t("Name"));

        return $properties;
    }
}