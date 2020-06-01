<?php

namespace Drupal\multi_step_jeff\Step;

use Drupal\multi_step_jeff\Button\StepTwoNextButton;
use Drupal\multi_step_jeff\Button\StepTwoPreviousButton;
use Drupal\multi_step_jeff\Validator\ValidatorRequired;

/**
 * Class StepTwo.
 *
 * @package Drupal\multi_step_jeff\Step
 */
class StepTwo extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_TWO;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      new StepTwoPreviousButton(),
      new StepTwoNextButton(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements() {

      $form['city'] = [
          '#type' => 'textfield',
          '#title' => t("City"),
          '#required' => TRUE,
          '#default_value' => isset($this->getValues()['city']) ? $this->getValues()['city'] : NULL,
      ];

      $form['phone_number'] = [
          '#type' => 'textfield',
          '#title' => t("Phone Number"),
          '#required' => FALSE,
          '#default_value' => isset($this->getValues()['phone_number']) ? $this->getValues()['phone_number'] : NULL,
      ];

      $form['address'] = [
          '#type' => 'textfield',
          '#title' => t("Address"),
          '#required' => FALSE,
          '#default_value' => isset($this->getValues()['address']) ? $this->getValues()['address'] : NULL,
      ];

      $form['first_name'] = [
          '#type' => 'hidden',
          '#default_value' => isset($this->getValues()['first_name']) ? $this->getValues()['first_name'] : NULL,
      ];

      $form['last_name'] = [
          '#type' => 'hidden',
          '#default_value' => isset($this->getValues()['last_name']) ? $this->getValues()['last_name'] : NULL,
      ];

      $form['gender'] = [
          '#type' => 'hidden',
          '#default_value' => isset($this->getValues()['gender']) ? $this->getValues()['gender'] : NULL,
      ];

      $form['date_of_birth'] = [
          '#type' => 'hidden',
          '#default_value' => isset($this->getValues()['date_of_birth']) ? $this->getValues()['date_of_birth'] : NULL,
      ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {
    return [
      'city',
      'phone_number',
      'address',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {
    return [
      'city' => [
        new ValidatorRequired("Please, put your City."),
      ],
    ];
  }

}