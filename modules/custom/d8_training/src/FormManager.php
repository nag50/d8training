<?php

namespace Drupal\d8_training;

use Drupal\Core\Database\Driver\mysql\Connection;

class FormManager {
  private $connection;
  public function __construct(Connection $database) {
    $this->connection = $database;
  }
  public function fetchData() {
    $rows = $this->connection->select('d8_training_table', 'd8t')->fields('d8t', array())->range(0,1)->execute()->fetchAssoc();
    return $rows['d8_field'];
  }
  public function addData($data) {
    $this->connection->insert('d8_training_table')->fields(array('d8_field' => $data))->execute();
  }
}
