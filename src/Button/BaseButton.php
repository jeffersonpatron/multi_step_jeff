<?php

namespace Drupal\multi_step_jeff\Button;

/**
 * Class BaseButton.
 *
 * @package Drupal\ms_ajax_form_example\Button
 */
abstract class BaseButton implements ButtonInterface {

  /**
   * {@inheritdoc}
   */
  public function ajaxify() {
    return TRUE;
  }

  /**
   * {@inheritdoc}
   */
  public function getSubmitHandler() {
    return FALSE;
  }

}
