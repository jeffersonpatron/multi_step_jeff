<?php

namespace Drupal\multi_step_jeff\Validator;

/**
 * Class ValidatorRequired.
 *
 * @package Drupal\multi_step_jeff\Validator
 */
class ValidatorRequired extends BaseValidator {

  /**
   * {@inheritdoc}
   */
  public function validates($value) {
    return is_array($value) ? !empty(array_filter($value)) : !empty($value);
  }

}
