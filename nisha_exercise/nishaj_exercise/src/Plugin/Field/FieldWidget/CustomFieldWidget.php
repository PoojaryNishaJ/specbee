<?php

namespace Drupal\nishaj_exercise\Plugin\Field\FieldWidget;

// Specifies the namespace for the class.
use Drupal\Core\Field\WidgetBase;
// Import the widgetbase class.
use Drupal\Core\Field\FieldItemListInterface;
// Import the FieldItemListInterface class.
use Drupal\Core\Form\FormStateInterface;

// Import the FormStateInterface class.

/**
 * Define the "custom field type".
 *
 * @FieldWidget(
 *   id = "custom_field_widget",
 *   label = @Translation("Custom Field Widget"),
 *   description = @Translation("Desc for Custom Field Widget"),
 *   field_types = {
 *     "custom_field_type"
 *   }
 * )
 */
class CustomFieldWidget extends WidgetBase {

  /**
   * {@inheritdoc}
   */
  public function formElement(FieldItemListInterface $items, $delta, array $element, array &$form, FormStateInterface $form_state) {
    // This is going to print the form in node add and edit page.
    $value = $items[$delta]->value ?? "";
    // To get the default value.
    $element = $element + [
      '#type' => 'textfield',
      '#suffix' => "<span>" . $this->getFieldSetting("moreinfo") . "</span>",
      '#default_value' => $value,
      '#attributes' => [
        'placeholder' => $this->getSetting('placeholder'),
      ],
    ];
    return ['value' => $element];
  }

  /**
   * {@inheritdoc}
   */
  public static function defaultSettings() {
    // Method defines the default settings for the widget.
    // In this case it only includes a placeholder setting with a default value.
    return [
      'placeholder' => 'default',
    ] + parent::defaultSettings();
  }

  /**
   * {@inheritdoc}
   */
  public function settingsForm(array $form, FormStateInterface $form_state) {
    // Method generates the form elements for the widget settings.
    // It creates a textfield element for the placeholder setting.
    $element['placeholder'] = [
      '#type' => 'textfield',
      '#title' => 'Placeholder text',
      '#default_value' => $this->getSetting('placeholder'),
    ];
    return $element;
  }

  /**
   * {@inheritdoc}
   */
  public function settingsSummary() {
    // Method provides a summary of the widget settings.
    // It returns array with a summary string based on the placeholder setting.
    $summary = [];
    $summary[] = $this->t("placeholder text: @placeholder", ["@placeholder" => $this->getSetting("placeholder")]);
    return $summary;
  }

}
