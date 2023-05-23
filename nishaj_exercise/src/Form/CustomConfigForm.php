<?php

namespace Drupal\nishaj_exercise\Form;            # defines the namespace for the form class.

use Drupal\Core\Form\ConfigFormBase;              # imports the ConfigFormBase class.
use Drupal\Core\Form\FormStateInterface;          # imports the FormStateInterface

class CustomConfigForm extends ConfigFormBase {   # The CustomConfigForm class extends ConfigFormBase and defines the below methods.

    /**
     * Settings Variable.
     */
    Const CONFIGNAME = "nishaj_exercise.settings"; # The constant CONFIGNAME is declared with a value of "nishaj_exercise.settings"

    /**
     * {@inheritdoc}
     */
    public function getFormId() {                  # getFormId() method returns the ID of the form.
        return "nishaj_exercise_settings";
    }

    /**
     * {@inheritdoc}
     */

    protected function getEditableConfigNames() {  # returns the name of the configuration objects
        return [
            static::CONFIGNAME,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {   # The buildForm() method is used to build the form.
        $config = $this->config(static::CONFIGNAME);                           #  retrieves the configuration object for the configuration with the name specified in the CONFIGNAME constant.
        $form['fullname']=[                                                    # creates an array that defines the form element for the "fullname" field.
            '#type' => 'textfield',                                            # indicates text field.
            '#title' => ' <span>Name</span>',                                  # sets the label for the form element as "Name", with the HTML <span> tag used to style the label.
            '#attached' => [                                                   # attaches the CSS library named "nishaj_exercise/css_lib" to the form element, which allows the styles defined in that library to be applied to the element.
                'library' => [
                    'nishaj_exercise/css_lib',
                ],
            ],
            '#default_value' => $config->get("fullname"),                      # sets the default value for the form element to the current value of the fullname.

        ];

        $form['email'] = [                               # a form element for email field.
            '#type' => 'email',                          # field type for email.
            '#title' => 'Email',                         # title for email.
            '#default_value' => $config->get("email"),   # get() method this means that if a value has been previously set for this field, it will be pre-populated with that value when the form is loaded.
        ];

        $form['place'] = [           # a form element for place field.
            '#type' => 'textfield',  # field type for place.
            '#title' => 'Place',     # field title for place.
            '#default_value' => $config->get("place"),   # get() method this means that if a value has been previously set for this field, it will be pre-populated with that value when the form is loaded.
        ];

        return Parent::buildForm($form, $form_state);    #  The Parent::buildForm($form, $form_state) method is called to ensure that the parent class's buildForm() method is executed.
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {   # The submitForm method is used to handle the form submission
        $config = $this->config(static::CONFIGNAME);
        $config->set("fullname", $form_state->getValue('fullname'));   # used to set the corresponding configuration values using $config->set() for fullname.
        $config->set("email", $form_state->getValue('email'));         # used to set the corresponding configuration values using $config->set() for email.
        $config->set("place", $form_state->getValue('place'));         # used to set the corresponding configuration values using $config->set() for place.
        $config->save();                                               # To save the configuration object.
    }

}

