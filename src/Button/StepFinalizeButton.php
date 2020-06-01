<?php

namespace Drupal\multi_step_jeff\Button;

use Drupal\multi_step_jeff\Step\StepsEnum;

/**
 * Class StepTwoPreviousButton.
 *
 * @package Drupal\multi_step_jeff\Button
 */
class StepFinalizeButton extends BaseButton {

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
      '#value' => t('Go Home'),
      '#goto_step' => StepsEnum::STEP_ONE,
      '#skip_validation' => FALSE,
    ];
  }

}
