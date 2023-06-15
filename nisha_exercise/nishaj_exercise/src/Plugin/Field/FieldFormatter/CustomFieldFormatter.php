<?php

namespace Drupal\nishaj_exercise\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Form\FormStateInterface;

// Whenever there is form in drupal we call the class FormStateInterface.


/**
 * Define the "custom field formatter".
 *
 * @FieldFormatter(
 *   id = "custom_field_formatter",
 *   label = @Translation("Custom Field Formatter"),
 *   description = @Translation("Desc for Custom Field Formatter"),
 *   field_types = {
 *     "custom_field_type"
 *   }
 * )
 */
class CustomFieldFormatter extends FormatterBase {

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Concating the statictext with the data.
    return [
      'concat' => 'Concat with ',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Used create the settings form.
    $form['concat'] = [
      '#type' => 'textfield',
      '#title' => 'Concatenate with',
      '#default_value' => $this->getSetting('concat'),
          // Default value that will be prepopulated.
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // To show the summary.
    $summary = [];
    $summary[] = $this->t("concatenate with : @concat", ["@concat" => $this->getSetting('concat')]);
    return $summary;
  }

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    // Helps to print the data in the frontend.
    $element = [];
    foreach ($items as $delta => $item) {
      // To add multiple fields.
      $element[$delta] = [
        '#markup' => $this->getSetting('concat') . $item->value,
            // To concatenate with the data.
      ];
    }
    return $element;
  }

}
