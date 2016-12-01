<?php
namespace Drupal\d8_training\Controller;

use \Drupal\Core\Controller\ControllerBase;
use Drupal\node\NodeInterface;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\dblog\Logger\DbLog;
use Drupal\Core\Access\AccessResult;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\DependencyInjection\ContainerInterface;

class NodelistingController extends ControllerBase {
  private $database;
  private $dblog;
  
  public function __construct(Connection $database, DbLog $dblog) {
    $this->database = $database;
    $this->dblog = $dblog;
  }

  public static function create(ContainerInterface $container){
    return new static(
      $container->get('database'),
      $container->get('logger.dblog')
    );
  }

  public function contenttype() {

    $limit = 1;
    if (empty($_REQUEST['page'])) {
      $start = 0;
    }
    else {
      $start = $_REQUEST['page'] * $limit;
    }
    $nodes = $this->database->select('node', 'n')->fields('n', array())->execute()->fetchAll();
//Get count query
$total = $total_count['count'];
//$page = pager_default_initialize($total, $limit);

    $headers = array(
      'nid',
      'vid',
      'type',
      'langcode'
    );

    foreach($nodes as $node) {
      $row = array();
      $row['data'][] = $node->nid;
      $row['data'][] = $node->vid;
      $row['data'][] = $node->type;
      $row['data'][] = $node->langcode;
      $rows[] = $row;
    }

    return array(
      '#theme' => 'table',
      '#caption' => $this->t('Sample Table'),
      '#rows' => $rows,
      '#header' => $headers,
      '#empty' => 'No recoreds'
    );
  }

  public function content() {
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

  public function access(Request $request){
    return AccessResult::allowed();
  }
}
