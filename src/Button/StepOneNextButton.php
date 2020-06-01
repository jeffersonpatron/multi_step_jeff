<?php

namespace Drupal\multi_step_jeff\Button;

use Drupal\multi_step_jeff\Step\StepsEnum;

/**
 * Class StepOneNextButton.
 *
 * @package Drupal\multi_step_jeff\Button
 */
class StepOneNextButton extends BaseButton {

  /**
   * {@inheritdoc}
   */
  public function getKey() {
    return 'next';
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    return [
      '#type' => 'submit',
      '#value' => t('Next'),
      '#goto_step' => StepsEnum::STEP_TWO,
    ];
  }

}
