<?php
namespace Drupal\bold_test_dogbreeds\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure example settings for this site.
 */
class UrlSettingsForm extends ConfigFormBase {

  /**
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'dogbreeds.settings';

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

    $form['url_get_image'] = [
      '#type' => 'textfield',
      '#title' => $this->t('URl to get image'),
      '#default_value' => $config->get('url_get_image'),
    ];

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('url_get_image', $form_state->getValue('url_get_image'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}
