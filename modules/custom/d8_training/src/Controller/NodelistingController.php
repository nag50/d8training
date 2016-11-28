<?php
namespace Drupal\d8_training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Component\Serialization\Json;

class NodelistingController extends ControllerBase {
  public function content() {
    return array(
      '#theme' => 'item_list',
      '#items' => array('D8 trainging')
    );
  }
  public function contenttype() {
    return array(
      '#theme' => 'item_list',
      '#items' => array('D8 trainging')
    );
  }

  public function nodeload(NodeInterface $node) {
    $body = $node->get('body')->getValue()[0]['value'];

    $con = array('Title' => $node->getTitle(), 'Body' => $body);
    //return new JsonResponse($con);
    return array('#markup' => Json::encode($con));
    
    return array(
      '#theme' => 'item_list',
      '#items' => array('Title' => $node->getTitle(), 'Body' => $body)
    );
  }
}
