<?php

namespace Drupal\multi_step_jeff\Step;
use Drupal\multi_step_jeff\Button\StepFinalizeButton;
/**
 * Class StepFinalize.
 *
 * @package Drupal\multi_step_jeff\Step
 */
class StepFinalize extends BaseStep {

  /**
   * {@inheritdoc}
   */
  protected function setStep() {
    return StepsEnum::STEP_FINALIZE;
  }

  /**
   * {@inheritdoc}
   */
  public function getButtons() {
    return [
        new StepFinalizeButton(),
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

}
