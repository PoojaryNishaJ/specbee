namespace Drupal\custom_token\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

class CustomConfigForm extends ConfigFormBase {

    /**
     * {@inheritdoc}
     */
    protected function getEditableConfigNames() {
        return [
            'custom_token.settings',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getFormId() {
        return 'custom_token_config_form';
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $form['helptext'] = [
            '#type' => 'textfield',
            '#title' => 'Help Text',
            '#default_value' => $config->get("helptext"),
        ];

        // Token support.
        if (\Drupal::moduleHandler()->moduleExists('token')) {
            $form['tokens'] = [
                '#title' => $this->t('Tokens'),
                '#type' => 'container',
            ];
            $form['tokens']['help'] = [
                '#theme' => 'token_tree_link',
                '#token_types' => [
                    'node',
                    'site',
                ],
                '#global_types' => FALSE,
                '#dialog' => TRUE,
            ];
        }

        return Parent::buildForm($form, $form_state);
    }

    /**
     * {@inheritdoc}
     */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $config = $this->config(static::CONFIGNAME);
        $config->set("helptext", $form_state->getValue('helptext'));
        $config->save();

        parent::submitForm($form, $form_state);
    }
}
