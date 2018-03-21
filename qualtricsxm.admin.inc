<?php
/**
 * @file
 *
 * Qualtrics admin conf form.
 */

function qualtricsxm_config_settings() {

  $form['api'] = array(
    '#type' => 'fieldset',
    '#title' => t('API Settings'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['api']['qualtricsxm_api_token'] = array(
    '#type' => 'textfield',
    '#title' => t('API token'),
    '#required' => TRUE,
    '#default_value' => variable_get('qualtricsxm_api_token', API_TOKEN),
    '#description' => t('Your API token. qualtricsxm_embed module requires API token.'),
  );

  $form['api']['qualtricsxm_datacenter'] = array(
    '#type' => 'textfield',
    '#title' => t('Datacenter'),
    '#required' => TRUE,
    '#default_value' => variable_get('qualtricsxm_datacenter', API_TOKEN),
    '#description' => t('Your datacenter.') . " <a href='https://api.qualtrics.com/docs/root-url' target='_blank'>" . "Find your DataCenter</a>",
  );

  $form['api']['qualtricsxm_organization_id'] = array(
    '#type' => 'textfield',
    '#title' => t('Organization ID'),
    '#default_value' => variable_get('qualtricsxm_organization_id', API_TOKEN),
    '#description' => t('Your datacenter.') . " <a href='https://api.qualtrics.com/docs/finding-qualtrics-ids' target='_blank'>" . "Find your Organization ID</a>",
  );

  $form['embedding'] = array(
    '#type' => 'fieldset',
    '#title' => t('Embedding options'),
    '#collapsible' => TRUE,
    '#collapsed' => FALSE,
  );

  $form['embedding']['qualtricsxm_secure_embed'] = array(
    '#type' => 'checkbox',
    '#title' => t('Secure embedding'),
    '#default_value' => variable_get('qualtricsxm_secure_embed', TRUE),
    '#description' => t('Whether to use https:// for embedding a survey or not.'),
  );

  return system_settings_form($form);
}

