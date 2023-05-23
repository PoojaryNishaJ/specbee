<?php

namespace Drupal\nishaj_exercise\Form;      # defines the namespace for the form class.
use Drupal\Core\Form\FormBase;              # The FormBase class is the base class for forms
use Drupal\Core\Form\FormStateInterface;    # The FormStateInterface interface provides a way to interact with the state of the form during processing and validation.

class CustomForm extends FormBase {

    public function getFormId()         # sets the unique ID of the form
    {
        return 'custom_form_user_details';   # The ID is set to 'custom_form_user_details'.
    }


    public function buildForm(array $form, FormStateInterface $form_state) {   # used to build the form.

    // Input fields.

        $form['firstname'] = [
            '#type' => 'textfield',
            '#title' => 'First Name',
            '#required' => true,
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

    public function submitForm(array &$form, FormStateInterface $form_state)    # The submitForm method is used to handle the form submission
    {

        \Drupal::messenger()->addMessage("User Details Submitted Successfully");
        \Drupal::database()->insert("user_details")->fields([  # used to initialize the  database service
            'firstname' => $form_state->getValue("firstname"), # used to get the first name value.
            'email' => $form_state->getValue("email"),         # used to get the email value.
            'gender' => $form_state->getValue("gender"),       # used to get the gender value.
        ])->execute();

    }
}


