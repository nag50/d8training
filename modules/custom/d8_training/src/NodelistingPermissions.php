<?php
namespace Drupal\d8_training;

use \Drupal\node\Entity\NodeType;

class NodelistingPermissions {
  public function getPermissions(){
    $types = NodeType::loadMultiple();
    $permissions = [];

    foreach($types as $type) {
      $type_name = $type->get('name');
      $permissions = array(
        'd8 training content access for ' . $type_name =>
          array('title' => 'd8 training content access for ' . $type_name),
        'd8 training content access for ' . $type_name =>
          array('title' => 'd8 training content access for ' . $type_name)
      );
    }
    return $permissions;
  }
}
