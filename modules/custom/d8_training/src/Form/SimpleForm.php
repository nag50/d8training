<?php

namespace Drupal\d8_training\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_training\FormManager;

class SimpleForm extends FormBase {
  private $frommanager;

  public function __construct(FormManager $frommanager) {
    $this->frommanager = $frommanager;
  }

  public static function create(ContainerInterface $container){
    return new static(
      $container->get('d8_training.form_manager')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'simple_form';
  }

 /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $val =  $this->frommanager->fetchData();
    $form['d8_field'] = array(
      '#type' => 'textfield',
      '#title' => 'Fill text',
      '#default_value' => $val
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
    $val = $form_state->getValue('d8_field');
    $this->frommanager->addData($val);
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Validation is optional.
    $val = $form_state->getValue('d8_field');
    if(strlen($val) < 5) {
      $form_state->setErrorByName('d8_field', $this->t('Please fill minimum 5 charecters'));
    }
  }
}
