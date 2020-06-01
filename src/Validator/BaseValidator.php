<?php

namespace Drupal\multi_step_jeff\Validator;

/**
 * Class BaseValidator.
 *
 * @package Drupal\multi_step_jeff\Validator
 */
abstract class BaseValidator implements ValidatorInterface {

  protected $errorMessage;

  /**
   * BaseValidator constructor.
   *
   * @param string $error_message
   *   Error message.
   */
  public function __construct($error_message) {
    $this->errorMessage = $error_message;
  }

  /**
   * {@inheritdoc}
   */
  public function getErrorMessage() {
    return $this->errorMessage;
  }

}
