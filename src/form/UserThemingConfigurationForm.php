<?php

namespace Drupal\user_theming\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Defines a form that configures size and shape settings of the user theming module.
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
        
        $yesnoOptions = array(
            'yes' => t('Yes'),
            'no' => t('No'),
        );
        
        $form['user_theming_heading'] = [
            '#type' => 'item',
            '#markup' => t('<h2>Available Configuration Options</h2>'),
        ];
        
        $form['user_module_styles_wrapper'] = array(
            '#type' => 'fieldset',
            '#weight' => 1,
            '#attributes' => array(
                'class' => array(
                    'use-module-styles',
                ),
            ),
        );
                
        $form['user_module_styles_wrapper']['use_module_styles'] = array(
            '#type' => 'radios',
            '#title' => t('Use Module Styles?'),
            '#required' => true,
            '#options' => $yesnoOptions,
            '#description' => t('If set to "Yes", the module will provide styles for user entities. If set to "No", no styling will be provided. '),
            '#default_value' => $config->get('use_module_styles') ? : 'yes',
        );
        
        $form['show_active_session_mark_wrapper'] = array(
            '#type' => 'fieldset',
            '#weight' => 5,
            '#attributes' => array(
                'class' => array(
                    'show-active-session-mark',
                ),
            ),
        );
        
        $form['show_active_session_mark_wrapper']['show_active_session_mark'] = array(
            '#type' => 'radios',
            '#title' => t('Show active user mark?'),
            '#required' => true,
            '#options' => $yesnoOptions,
            '#description' => t('If set to "Yes", this will show an active session mark. '),
            '#default_value' => $config->get('show_active_session_mark') ? : 'yes',
        );
        
        $form['form_details'] = [
            '#type' => 'item',
            '#weight' => 10,
            '#markup' => t('
<h3>This module provides:</h3>
<ul>
<li><strong>Display Modes:</strong> Full, Compact, Token</li>
<li><strong>Template Files:</strong> user--full.html.twig, user--compact.html.twig, user--token.html.twig</li>
<li><strong>Views:</strong> users_compact_views_block, users_token_views_block</li>
<li><strong>Fields:</strong> field_user_first_name, field_user_last_name, field_user_title, user_picture</li>
</ul>
            '),
        ];
        
        $form['form_additional_info'] = [
            '#type' => 'item',
            '#weight' => 50,
            '#markup' => t('
            <p>It also provides optional styling for the various user displays. Built on Less, CSS Grid, and mobile responsive design.</p><p>&nbsp;</p>
            '),
        ];
        
        return parent::buildForm($form, $form_state);
    }

  /**
   * {@inheritdoc}
   */
    public function submitForm(array &$form, FormStateInterface $form_state) {
        $values = $form_state->getValues();
        
        $this->config('user_theming.user_theming_settings')->set('use_module_styles', $values['use_module_styles']);
        $this->config('user_theming.user_theming_settings')->set('show_active_session_mark', $values['show_active_session_mark'])->save();
        parent::submitForm($form, $form_state);
        
    }

}