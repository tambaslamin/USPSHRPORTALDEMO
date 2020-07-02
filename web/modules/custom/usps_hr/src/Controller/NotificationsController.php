<?php

namespace Drupal\usps_hr\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Defines NotificationsController class.
 */
class NotificationsController extends ControllerBase {

  /**
   * The Database Connection.
   *
   * @var \Drupal\Core\Database\Connection
   */
  protected $database;

  /**
   * Drupal\Core\Session\AccountInterface definition.
   *
   * @var \Drupal\Core\Session\AccountInterface
   */
  protected $currentUser;

  /**
   * The Date Formatter service.
   *
   * @var \Drupal\Core\Datetime\DateFormatter
   */
  protected $dateFormatter;

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    $database = $container->get('database');
    $current_user = $container->get('current_user');
    $date_formatter = $container->get('date.formatter');
    return new static($database, $current_user, $date_formatter);
  }

  /**
   * {@inheritdoc}
   */
  public function __construct($database, $current_user, $date_formatter) {
    $this->database = $database;
    $this->currentUser = $current_user;
    $this->dateFormatter = $date_formatter;
  }

  /**
   * Display the markup.
   *
   * @return array
   *   Return markup array.
   */
  public function content() {
    $connection = $this->database;
    $date_formatter = $this->dateFormatter;

    // Get logged user session.
    $currentUser = $this->currentUser;

    $uid = $currentUser->id();
    $totalCount = 0;
    $unreadCount = 0;
    $notificationList = [];

    $query = $connection->select('notifications', 'n');
    $query->fields('n', [
      'id',
      'message',
      'status',
      'created',
    ]);
    $query->condition('n.entity_uid', $uid);
    $query->orderBy('n.created', 'DESC');
    $res = $query->execute();

    // Date constants.
    $today = $date_formatter->format(REQUEST_TIME, 'custom', 'Y-m-d');

    while ($notification = $res->fetchObject()) {

      if (!empty($notification->message)) {
        $created_day = $date_formatter->format($notification->created, 'custom', 'Y-m-d');
        if ($created_day == $today) {
          $created = $date_formatter->format($notification->created, 'custom', 'g:i A');
        }
        else {
          $created = $date_formatter->format($notification->created, 'custom', 'n/j/Y');
        }

        $notificationList[] = [
          'id'      => $notification->id,
          'message' => $notification->message,
          'status'  => $notification->status,
          'created' => $created,
        ];

        if ($notification->status == 0) {
          $unreadCount++;
        }

        $totalCount++;
      }
    }

    $content = [];

    if (!empty($notificationList)) {

      // Header.
      $content['header'] = [
        '#type' => 'container',
        '#attributes' => [
          'id' => ['notifications-header'],
          'class' => ['row', 'notifications-header'],
        ],
      ];
      $content['header']['created'] = [
        '#markup' => $this->t('Date'),
        '#prefix' => '<div class="col-2">',
        '#suffix' => '</div>',
      ];
      $content['header']['message'] = [
        '#markup' => $this->t('Title'),
        '#prefix' => '<div class="col-10">',
        '#suffix' => '</div>',
      ];

      // Display notifications.
      foreach ($notificationList as $notification) {
        $content['notification_' . $notification['id']] = [
          '#type' => 'container',
          '#attributes' => [
            'id' => ['notification_' . $notification['id']],
            'class' => ['row', 'notification-row'],
            'data-id' => [$notification['id']],
          ],
        ];
        $status = $notification['status'] == 0 ? 'unread' : '';
        $content['notification_' . $notification['id']]['open_li'] = [
          '#markup' => '<li class="' . $status . '" data-id="' . $notification['id'] . '">',
        ];
        $content['notification_' . $notification['id']]['created'] = [
          '#markup' => $notification['created'],
          '#prefix' => '<div class="col-2">',
          '#suffix' => '</div>',
        ];
        $content['notification_' . $notification['id']]['message_container'] = [
          '#type' => 'container',
          '#attributes' => [
            'id' => ['notification_' . $notification['id']],
            'class' => ['col-10'],
          ],
        ];
        $notification['message'] .= '<span class="chevron-down toggle-actions">&nbsp;</span>';
        $content['notification_' . $notification['id']]['message_container']['message'] = [
          '#markup' => $notification['message'],
          '#prefix' => '<div class="message-title">',
          '#suffix' => '</div>',
        ];
        $actions = '<span class="notification-remove btn btn-light">Delete</span> ';
        $actions .= '<span class="btn btn-light notification-archive notification-msg">Archive<span data-link=""></span></span>';
        $content['notification_' . $notification['id']]['actions'] = [
          '#markup' => $actions,
        ];
        $content['notification_' . $notification['id']]['close_li'] = [
          '#markup' => '</li>',
        ];
      }
    }
    else {
      $content['no_notifications'] = [
        '#markup' => $this->t('There are no notifications to display.'),
        '#prefix' => '<div class="no-notifications">',
        '#suffix' => '</div>',
      ];
    }

    $content['#attached']['library'][] = 'uspshrdemo/notifications-page';

    return $content;
  }

}
