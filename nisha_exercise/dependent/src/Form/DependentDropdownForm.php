<?php

namespace Drupal\dependent\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Link;
use Drupal\node\Entity\Node;


class DependentDropdownForm extends FormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dependent_dropdown_Form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $nids = \Drupal::entityQuery('node')
            ->accessCheck(TRUE)
            ->condition('status' , 1)
            ->condition('type' , 'article')
            ->sort('created' , 'DESC')
            ->execute();
    $nodes=Node::loadMultiple($nids);
    //print_r(array_keys($nodes));exit;[gettype]

    //print_r($nodes[1]);exit;
    foreach($nodes as $node){
      // print_r($node->get('field_tags')->getValue());exit;
      }



    $opt = static::foodCategory();
    if (empty($form_state->getValue('category'))) {
        $cat = "none";
    }
    else {
        $cat = $form_state->getValue('category');
    }
    $form['category'] = [
        '#type' => 'select',
        '#title' => 'Food Category',
        '#options' => $opt,
        'default_value' => $cat,
        '#ajax' => [
            'callback' => '::DropdownCallback',
            'wrapper' => 'field-container',
            'event' => 'change'
        ]
    ];
    $form['availableitems'] = [
        '#type' => 'select',
        '#title' => 'Available Items',
        '#options' =>static::availableItems($cat),
        '#default_value' => !empty($form_state->getValue('availableitems')) ? $form_state->getValue('availableitems') : '',
        '#prefix' => '<div id="field-container"',
        '#suffix' => '</div>',
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
    $trigger = (string) $form_state->getTriggeringElement()['#value'];
    if ($trigger != 'submit') {
        $form_state->setRebuild();
    }
  }

  public function DropdownCallback(array &$form, FormStateInterface $form_state) {
    return $form['availableitems'];
  }

  public function foodCategory() {
    return [
        'none' => '-none-',
        'fruits' => 'fruits',
        'snacks' => 'snacks',
    ];
  }

  public function availableItems($cat) {
    switch ($cat) {
        case 'fruits':
            $opt = [
                'Apple' => 'Apple',
                'Orange' => 'Orange',
                'Mango' => 'Mango',
            ];
        break;
        case 'snacks':
            $opt = [
                'pani poori' => 'pani poori',
                'kachori' => 'kachori',
                'vada' => 'vada',
            ];
        break;
        default:
          $opt = ['none' => '-none-'];
        break;
    }
    return $opt;
  }



}
