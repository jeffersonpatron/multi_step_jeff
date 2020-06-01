<?php

namespace Drupal\multi_step_jeff\Step;

use Drupal\multi_step_jeff\Button\StepThreeFinishButton;
use Drupal\multi_step_jeff\Button\StepThreePreviousButton;

/**
 * Class StepThree.
 *
 * @package Drupal\multi_step_jeff\Step
 */
class StepThree extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_THREE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
      new StepThreePreviousButton(),
      new StepThreeFinishButton(),
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function buildStepFormElements() {

      $form['completed'] = [
          '#markup' => t('You have completed the Form!'),
      ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldNames() {

  }

  /**
   * {@inheritdoc}
   */
  public function getFieldsValidators() {

  }

}
