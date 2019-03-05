<?php

namespace Drupal\user_theming\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form for the user theming module.
 */
class UserThemingConfigurationForm extends ConfigFormBase {

 /**
  * {@inheritdoc}
  */
  public function getFormId() {
    return 'user_theming_settings';
  }

 /**
  * {@inheritdoc}
  */
  protected function getEditableConfigNames() {
    return [
      'user_theming.user_theming_settings',
    ];
  }

 /**
  * {@inheritdoc}
  */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    $config = $this->config('user_theming.user_theming_settings');
    
    $yesnoOptions = [
      'yes' => t('Yes'),
      'no' => t('No'),
    ];
    
    $form['user_theming_heading'] = [
      '#type' => 'item',
      '#markup' => t('<h2>Available Configuration Options</h2>'),
    ];
    
    $form['show_active_session_mark_wrapper'] = [
      '#type' => 'fieldset',
      '#weight' => 5,
      '#attributes' => [
        'class' => [
          'show-active-session-mark',
        ],
      ],
    ];
    
    $form['show_active_session_mark_wrapper']['show_active_session_mark'] = [
      '#type' => 'radios',
      '#title' => t('Show active user mark?'),
      '#required' => true,
      '#options' => $yesnoOptions,
      '#description' => t('If set to "Yes", this will show an active session mark.'),
      '#default_value' => $config->get('show_active_session_mark') ?: 'yes',
    ];

    $form['use_module_provided_css_wrapper'] = [
      '#type' => 'fieldset',
      '#weight' => 5,
      '#attributes' => [
        'class' => [
          'show-active-session-mark',
        ],
      ],
    ];
    
    $form['use_module_provided_css_wrapper']['use_module_provided_css'] = [
      '#type' => 'radios',
      '#title' => t('Use module provided CSS?'),
      '#required' => true,
      '#options' => $yesnoOptions,
      '#description' => t('If set to "Yes", this will use the module provided CSS.'),
      '#default_value' => $config->get('use_module_provided_css') ?: 'yes',
    ];
    
    return parent::buildForm($form, $form_state);
  }

 /**
  * {@inheritdoc}
  */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();
    
    $this->configFactory->getEditable('user_theming.user_theming_settings')
     ->set('show_active_session_mark', $values['show_active_session_mark'])
     ->set('use_module_provided_css', $values['use_module_provided_css'])
     ->save();
     
    parent::submitForm($form, $form_state);
    
  }

}