<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Component\Utility\Tags;
use Drupal\Core\Session\AccountProxy;

/**
 * Provides a 'CacheBlock' block.
 *
 * @Block(
 *  id = "cache_block",
 *  admin_label = @Translation("Cache block"),
 * )
 */
class CacheBlock extends BlockBase implements ContainerFactoryPluginInterface {

  /**
   * Drupal\Core\Database\Driver\mysql\Connection definition.
   *
   * @var Drupal\Core\Database\Driver\mysql\Connection
   */
  protected $database;
  protected $account;
  /**
   * Construct.
   *
   * @param array $configuration
   *   A configuration array containing information about the plugin instance.
   * @param string $plugin_id
   *   The plugin_id for the plugin instance.
   * @param string $plugin_definition
   *   The plugin implementation definition.
   */
  public function __construct(
        array $configuration,
        $plugin_id,
        $plugin_definition,
        Connection $database,
        AccountProxy $account
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->database = $database;
    $this->account = $account;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('database'),
      $container->get('current_user')
    );
  }



  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $result = $this->database->select('node_field_data', 'nfd')->distinct('nid')->fields('nfd', array());
    //$result = $result->join('node_field_data', 'nfd', 'nfd.vid = n.vid');
    $result= $result->orderBy('nfd.created', 'DESC')->range(0,3)->execute()->fetchAll();
    $title = [];
    $tags = ['node_list'];
    $mail = $this->account->getEmail();
    foreach($result as $res) {
      $titles[] = $res->title.'-'.$mail;
      $tags[] = 'node:'.$res->vid;
    }
    $titles = implode(' | ', $titles);
    return array('#markup' => $titles, '#cache' => ['tags' => $tags]);
  }
}
