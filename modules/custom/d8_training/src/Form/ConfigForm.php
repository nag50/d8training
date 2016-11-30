<?php

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Driver\mysql\Connection;

class ConfigForm extends ConfigFormBase {

  protected function getEditableConfigNames() {
    return ['d8_training.configform'];
  }
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'config_form';
  }

 /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('d8_training.configform');
    $form['d8_config'] = array(
      '#type' => 'textfield',
      '#title' => 'Fill config text',
      '#default_value' => $config->get('d8_config'),
    );
    $form['submit'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Submit')
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    parent::submitForm($form, $form_state);
    $this->config('d8_training.configform')
    ->set('d8_config', $form_state->getValue('d8_config'))
    ->save();
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);
  }
}
