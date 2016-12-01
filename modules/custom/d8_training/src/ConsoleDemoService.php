<?php

namespace Drupal\d8_training;

use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Logger\LoggerChannelFactory;
use Drupal\Core\Config\ConfigFactory;

/**
 * Class ConsoleDemoService.
 *
 * @package Drupal\d8_training
 */
class ConsoleDemoService implements ConsoleDemoServiceInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;

  /**
   * Drupal\Core\Logger\LoggerChannelFactory definition.
   *
   * @var Drupal\Core\Logger\LoggerChannelFactory
   */
  protected $logger_factory;

  /**
   * Drupal\Core\Config\ConfigFactory definition.
   *
   * @var Drupal\Core\Config\ConfigFactory
   */
  protected $config_factory;
  /**
   * Constructor.
   */
  public function __construct(Connection $database, LoggerChannelFactory $logger_factory, ConfigFactory $config_factory) {
    $this->database = $database;
    $this->logger_factory = $logger_factory;
    $this->config_factory = $config_factory;
  }

}
