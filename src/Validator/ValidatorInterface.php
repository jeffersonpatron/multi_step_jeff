<?php

namespace Drupal\multi_step_jeff\Validator;

/**
 * Interface ValidatorInterface.
 *
 * @package Drupal\multi_step_jeff\Validator
 */
interface ValidatorInterface {

  /**
   * Returns bool indicating if validation is ok.
   */
  public function validates($value);

  /**
   * Returns error message.
   */
  public function getErrorMessage();

}
