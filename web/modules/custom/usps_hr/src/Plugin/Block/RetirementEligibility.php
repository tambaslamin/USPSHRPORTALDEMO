<?php

namespace Drupal\usps_hr\Plugin\Block;

use Drupal\usps_hr\Services\Retirement;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Url;

/**
 * Provides a block that displays Retirement Eligibility.
 *
 * @Block(
 *   id = "retirement_eligibility",
 *   admin_label = @Translation("Retirement Eligibility"),
 * )
 */
class RetirementEligibility extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Retirement service.
   *
   * @var Drupal\usps_hr\Retirement
   */
  protected $retirement;

  /**
   * {@inheritdoc}
   *
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param Drupal\usps_hr\Retirement $retirement
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Retirement $retirement) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->retirement = $retirement;
  }

  /**
   * {@inheritdoc}
   *
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('usps_hr.retirement')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $retirement_eligibility = $this->retirement->retirementEligibility();
    if (!empty($retirement_eligibility['eligibility'])) {
      if ($retirement_eligibility['eligibility'] == 'now') {
        $content['eligible'] = [
          '#markup' => $this->t('Congratulations! You are now eligible for retirement.'),
        ];
        $url = Url::fromUri('internal:/user');
        $content['setdate'] = [
          '#title' => $this->t('Set Retirement Date'),
          '#type' => 'link',
          '#url' => $url,
          '#attributes' => [
            'class' => 'btn btn-primary btn-block',
          ],
          '#prefix' => '<div class="retirement-eligibility-lower-link-wrapper">',
          '#suffix' => '</div>'
        ];
      }
      if ($retirement_eligibility['eligibility'] == 'future') {
        $content['eligible'] = [
          '#markup' => $this->t('The time remaining until your retirement date of <strong>' . $retirement_eligibility['date'] . '</strong>'),
          '#prefix' => '<div class="retirement_eligibility_intro">',
          '#suffix' => '</div>'
        ];

        $content['container'] = [
          '#type' => 'container',
          '#attributes' => [
            'class' => 'retirement-eligibility-diff-wrapper row',
          ],
        ];
        // retirement diff blocks
        preg_match_all('/[^\s]+\s+[^\s]+|[^\s]+/m', $retirement_eligibility['diff'], $retiremement_eligibility_array, PREG_SET_ORDER, 0);
        $i = 0;
        foreach ($retiremement_eligibility_array as $retiremement_eligibility_val) {
          $date_components = explode(' ', $retiremement_eligibility_val[0]);
          $content['container']['retirement_eligibility_val_' . $i] = [
            '#type' => 'container',
            '#attributes' => [
              'class' => 'col',
            ],
          ];
          $date_component_i = 0;
          foreach ($date_components as $date_component) {
            $content['container']['retirement_eligibility_val_' . $i]['component_' . $date_component_i] = [
              '#markup' => $date_component,
              '#prefix' => '<div class="retirement-eligibility-diff-component">',
              '#suffix' => '</div>'
            ];
            $date_component_i++;
          }
          $i++;
        }

        $url = Url::fromUri('internal:/user');
        $content['setdate'] = [
          '#title' => $this->t('Full Retirement Information'),
          '#type' => 'link',
          '#url' => $url,
          '#prefix' => '<div class="retirement-eligibility-lower-link-wrapper">',
          '#suffix' => '</div>'
        ];
      }
      return $content;
    }
    $content['no_detail'] = [
      '#markup' => $this->t('No retirement information available.'),
    ];
    return $content;
  }

  /**
   * {@inheritdoc}
   */
  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'access content');
  }

}
