<?php

namespace Drupal\multi_step_jeff\Form;

use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\StringTranslation\StringTranslationTrait;
use Drupal\multi_step_jeff\Manager\StepManager;
use Drupal\multi_step_jeff\Step\StepsEnum;
use Drupal\Core\Database\Database;

/**
 * Provides multi step ajax example form.
 *
 * @package Drupal\multi_step_jeff\Form
 */
class MultiStepJeff extends FormBase {
  use StringTranslationTrait;

  /**
   * Step Id.
   *
   * @var \Drupal\multi_step_jeff\Step\StepsEnum
   */
  protected $stepId;

  /**
   * Multi steps of the form.
   *
   * @var \Drupal\multi_step_jeff\Step\StepInterface
   */
  protected $step;

  /**
   * Step manager instance.
   *
   * @var \Drupal\multi_step_jeff\Manager\StepManager
   */
  protected $stepManager;

  /**
   * {@inheritdoc}
   */
  public function __construct() {
    $this->stepId = StepsEnum::STEP_ONE;
    $this->stepManager = new StepManager();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'multi_step_jeff';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['wrapper-messages'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'messages-wrapper',
      ],
    ];

    $form['wrapper'] = [
      '#type' => 'container',
      '#attributes' => [
        'id' => 'form-wrapper',
      ],
    ];

    // Get step from step manager.
    $this->step = $this->stepManager->getStep($this->stepId);

    // Attach step form elements.
    $form['wrapper'] += $this->step->buildStepFormElements();

    // Attach buttons.
    $form['wrapper']['actions']['#type'] = 'actions';
    $buttons = $this->step->getButtons();
    foreach ($buttons as $button) {
      /** @var \Drupal\ms_ajax_form_example\Button\ButtonInterface $button */
      $form['wrapper']['actions'][$button->getKey()] = $button->build();

      if ($button->ajaxify()) {
        // Add ajax to button.
        $form['wrapper']['actions'][$button->getKey()]['#ajax'] = [
          'callback' => [$this, 'loadStep'],
          'wrapper' => 'form-wrapper',
          'effect' => 'fade',
        ];
      }

      $callable = [$this, $button->getSubmitHandler()];
      if ($button->getSubmitHandler() && is_callable($callable)) {
        // Attach submit handler to button, so we can execute it later on..
        $form['wrapper']['actions'][$button->getKey()]['#submit_handler'] = $button->getSubmitHandler();
      }
    }

    return $form;

  }

  /**
   * Ajax callback to load new step.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state interface.
   *
   * @return \Drupal\Core\Ajax\AjaxResponse
   *   Ajax response.
   */
  public function loadStep(array &$form, FormStateInterface $form_state) {
    $response = new AjaxResponse();

    $messages = drupal_get_messages();
    if (!empty($messages)) {
      // Form did not validate, get messages and render them.
      $messages = [
        '#theme' => 'status_messages',
        '#message_list' => $messages,
        '#status_headings' => [
          'status' => $this->t('Status message'),
          'error' => $this->t('Error message'),
          'warning' => $this->t('Warning message'),
        ],
      ];
      $response->addCommand(new HtmlCommand('#messages-wrapper', $messages));
    }
    else {
      // Remove messages.
      $response->addCommand(new HtmlCommand('#messages-wrapper', ''));
    }

    // Update Form.
    $response->addCommand(new HtmlCommand('#form-wrapper',
      $form['wrapper']));

    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $triggering_element = $form_state->getTriggeringElement();
    // Only validate if validation doesn't have to be skipped.
    // For example on "previous" button.
    if (empty($triggering_element['#skip_validation']) && $fields_validators = $this->step->getFieldsValidators()) {
      // Validate fields.
      foreach ($fields_validators as $field => $validators) {
        // Validate all validators for field.
        $field_value = $form_state->getValue($field);
        foreach ($validators as $validator) {
          if (!$validator->validates($field_value)) {
            $form_state->setErrorByName($field, $validator->getErrorMessage());
          }
        }
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // Save filled values to step. So we can use them as default_value later on.
    $values = [];
    foreach ($this->step->getFieldNames() as $name) {
      $values[$name] = $form_state->getValue($name);
    }
    $this->step->setValues($values);
    // Add step to manager.
    $this->stepManager->addStep($this->step);
    // Set step to navigate to.
    $triggering_element = $form_state->getTriggeringElement();
    $this->stepId = $triggering_element['#goto_step'];

    // If an extra submit handler is set, execute it.
    // We already tested if it is callable before.
    if (isset($triggering_element['#submit_handler'])) {
      $this->{$triggering_element['#submit_handler']}($form, $form_state);
    }

    $form_state->setRebuild(TRUE);
  }

  /**
   * Submit handler for last step of form.
   *
   * @param array $form
   *   Form array.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   Form state interface.
   */
  public function submitValues(array &$form, FormStateInterface $form_state) {

      $conn = Database::getConnection();
      $conn->insert('new_users')->fields(
          array(
              'first_name' => $form_state->getValue('first_name'),
              'last_name' => $form_state->getValue('last_name'),
              'gender' => $form_state->getValue('gender'),
              'date_of_birth' => $form_state->getValue('date_of_birth'),
              'city' => $form_state->getValue('city'),
              'phone_number' => $form_state->getValue('phone_number'),
              'address' => $form_state->getValue('address'),
              'created_date' => date("Y-m-d H:i:s", time()),
          )
      )->execute();
      // Submit all values to DB or do whatever you want on submit.
      $form_state->setRebuild(FALSE);
  }

}