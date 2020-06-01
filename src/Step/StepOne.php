<?php

namespace Drupal\multi_step_jeff\Step;

use Drupal\multi_step_jeff\Button\StepOneNextButton;
use Drupal\multi_step_jeff\Validator\ValidatorRequired;
use Drupal\Core\Datetime\DrupalDateTime;

/**
 * Class StepOne.
 *
 * @package Drupal\multi_step_jeff\Step
 */
class StepOne extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_ONE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      new StepOneNextButton(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements() {
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => t("First Name"),
      '#required' => TRUE,
      '#default_value' => isset($this->getValues()['first_name']) ? $this->getValues()['first_name'] : NULL,
    ];

    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => t("Last Name"),
      '#required' => TRUE,
      '#default_value' => isset($this->getValues()['last_name']) ? $this->getValues()['last_name'] : NULL,
    ];

    $form['gender'] = [
      '#type' => 'radios',
      '#title' => t("Gender"),
      '#required' => TRUE,
      '#options' => array('Male'=>t('Male'),'Female'=>t('Female')),
    ];

    $form['date_of_birth'] = [
      '#type' => 'date',
      '#title' => t("Date of Birth"),
      '#required' => TRUE,
        '#default_value' => DrupalDateTime::createFromTimestamp(strtotime('2018-02-15')),
        ];

      return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return [
      'first_name',
      'last_name',
      'gender',
      'date_of_birth',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {
    return [
      'first_name' => [
        new ValidatorRequired("Please, put your First Name"),
      ],
      'last_name' => [
        new ValidatorRequired("Please, put your Last Name"),
      ],
      'gender' => [
        new ValidatorRequired("Please, choose your Gender"),
      ],
      'date_of_birth' => [
        new ValidatorRequired("Please, put your Day of Birth"),
      ],
    ];

  }

}