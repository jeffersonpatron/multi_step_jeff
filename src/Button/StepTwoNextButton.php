<?php

namespace Drupal\multi_step_jeff\Button;

use Drupal\multi_step_jeff\Step\StepsEnum;

/**
 * Class StepTwoNextButton.
 *
 * @package Drupal\ms_ajax_form_example\Button
 */
class StepTwoNextButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'finish';
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'submit',
      '#value' => t('Finish'),
      '#goto_step' => StepsEnum::STEP_FINALIZE,
      '#submit_handler' => 'submitValues',
    ];
  }
    public function getSubmitHandler() {
        return 'submitIntake';
    }
}
