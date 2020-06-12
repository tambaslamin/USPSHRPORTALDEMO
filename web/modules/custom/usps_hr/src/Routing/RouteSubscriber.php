<?php

namespace Drupal\usps_hr\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {

    $entityUserEditFormRoute = $collection->get('user.login');

    if ($entityUserEditFormRoute) {
      $entityUserEditFormRoute->setDefaults([
        '_form' => '\Drupal\user\Form\UserLoginForm',
        '_title' => 'Employees login to the USPS HR Portal here',
      ]);
    }
  }

}
