<?php

namespace Drupal\usps_hr\Services;

use Drupal\Core\Session\AccountProxy;

/**
 * Class Retirement.
 */
class Retirement implements RetirementInterface {

  /**
   * Account Interface.
   *
   * @var AccountInterface
   */
  protected $account;

  /**
   * Class constructor.
   */
  public function __construct(AccountProxy $account) {
    $this->account = $account;
  }

  /**
   * {@inheritDoc}
   */
  public function retirementEligibility() {
    $list = \Drupal::entityTypeManager()
      ->getStorage('profile')
      ->loadByProperties([
        'uid' => $this->account->id(),
        'type' => 'usps_person_profile',
      ]);

    $profile = reset($list);
    $retirement_eligible = (!empty($profile->get('field_profile_retirement_eligibl')->getValue()[0]['value']))
      ? $profile->get('field_profile_retirement_eligibl')->getValue()[0]['value']
      : FALSE;
    $return['eligibility'] = $retirement_eligible;
    if (!empty($profile->get('field_profile_retirement_date')->getValue()[0]['value'])) {
      $retirement_date = $profile->get('field_profile_retirement_date');
      $options['granularity'] = 3;
      $retirement_date_timestamp = $retirement_date->date->getTimestamp();
      if (REQUEST_TIME < $retirement_date_timestamp) {
        $retirement_date_diff =
          \Drupal::service('date.formatter')
            ->formatDiff(REQUEST_TIME, $retirement_date_timestamp, $options);
        $return['date'] = $retirement_date->date->format('F d, Y');
        $return['diff'] = $retirement_date_diff;
      }
    }
    return $return;
  }

}
