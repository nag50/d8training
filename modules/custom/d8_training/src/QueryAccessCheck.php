<?php
namespace Drupal\d8_training;

use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Access\AccessResult;
use Drupal\Core\Routing\Access\AccessInterface;

class QueryAccessCheck implements AccessInterface {
  public function access(Request $request) {
    $qs = $request->getQueryString();
    if($qs) {
      return AccessResult::allowed()->cachePerPermissions();
    }
    else {
      return AccessResult::forbidden();
    }
  }
}
