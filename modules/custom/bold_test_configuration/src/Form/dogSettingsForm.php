<?php
namespace Drupal\bold_test_configuration\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class DogSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'dogconfiguration.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'dog_breeds_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);

    $form['dog_breed'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Dog Breed'),
      '#default_value' => $config->get('dog_breed'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('dog_breed', $form_state->getValue('dog_breed'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
