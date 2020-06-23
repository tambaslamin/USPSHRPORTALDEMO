<?php

namespace Drupal\usps_hr\Services;

/**
 * Functionalities related to Retirement Date store in user profile.
 *
 * @package \Drupal\usps_hr
 */
interface RetirementInterface {

  /**
   * Returns retirement date.
   *
   * @return mixed
   *   bool: false if no retirement date
   *   bool: true if eligible
   *   date object if future
   */
  public function retirementEligibility();

}
