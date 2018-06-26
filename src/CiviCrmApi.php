<?php

namespace Drupal\civicrm_entity;

use Drupal\civicrm\Civicrm;

class CiviCrmApi implements CiviCrmApiInterface {

  /**
   * The CiviCRM service.
   *
   * @var \Drupal\civicrm\Civicrm
   */
  protected $civicrm;

  /**
   * Constructs a new CiviCrmApi object.
   *
   * @param \Drupal\civicrm\Civicrm $civicrm
   *   The CiviCRM service.
   */
  public function __construct(Civicrm $civicrm) {
    $this->civicrm = $civicrm;
  }

  /**
   * {@inheritdoc}
   */
  public function get($entity, array $params = []) {
    $this->initialize();
    $result = civicrm_api3($entity, 'get', $params);
    return $result['values'];
  }

  /**
   * {@inheritdoc}
   */
  public function delete($entity, array $params) {
    $this->initialize();
    $result = civicrm_api3($entity, 'delete', $params);
    return $result['values'];
  }

  /**
   * {@inheritdoc}
   */
  public function save($entity, array $params) {
    $this->initialize();
    $result = civicrm_api3($entity, 'create', $params);
    return $result;
  }

  /**
   * {@inheritdoc}
   */
  public function getFields($entity, $action = '') {
    $this->initialize();
    $result = civicrm_api3($entity, 'getfields', [
      'sequential' => 1,
      'action' => $action,
    ]);
    return $result['values'];
  }

  /**
   * {@inheritdoc}
   */
  public function getOptions($entity, $field_name) {
    $this->initialize();
    $result = civicrm_api3($entity, 'getoptions', ['field' => $field_name]);
    return $result['values'];
  }

  /**
   * Ensures that CiviCRM is loaded and API function available.
   */
  protected function initialize() {
    if (!function_exists('civicrm_api3')) {
      $this->civicrm->initialize();
    }
  }

}