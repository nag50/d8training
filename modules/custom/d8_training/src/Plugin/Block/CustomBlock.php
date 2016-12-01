<?php
namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Database\Driver\mysql\Connection;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\d8_training\OpenWeatherForecaster;

/**
 * Provibes a Weather block.
 *
 * @Block(
 *  id = "custom_block",
 *  admin_label = @Translation("Weather block"),
 * )
 */
class CustomBlock extends BlockBase implements ContainerFactoryPluginInterface {
  private $weartherForecaster;
  public function __construct(array $configuration, $plugin_id, $plugin_definition, OpenWeatherForecaster $weartherForecaster) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->weartherForecaster = $weartherForecaster;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('d8_training.weather_forecaster')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $block_config = $this->getConfiguration();
    $form['city_name'] = array(
      '#type' => 'select',
      '#title' => 'Fill text',
      '#options' => array('mumbai' => 'Mumbai', 'hyderabad' => 'Hyderabad', 'bangalore' => 'Bangalore'),
      '#default_value' => $block_config['city_name']
    );
    return $form;
  }
  public function build() {
    $block_config = $this->getConfiguration();
    $weather = $this->weartherForecaster->fetchWeatherData($block_config['city_name']);
    $header = array($weather['name']);
    $rows = [];
    $rows[]['data'] = array('Longitude', $weather['coord']['lon']);
    $rows[]['data'] = array('Latitude', $weather['coord']['lat']);
    $rows[]['data'] = array('Temparature', $weather['main']['temp']);
    $rows[]['data'] = array('Humidity', $weather['main']['humidity']);
    //return array('#theme' => 'table', '#rows' => $rows, '#header' => $header, '#caption' => $this->t('Weather'));
    $weather_data = [
      'city' => $weather['name'],
      'lon' => $weather['coord']['lon'],
      'lat' => $weather['coord']['lat'],
      'temp'=> $weather['main']['temp'],
      'hum'=> $weather['main']['humidity']
    ];
    return array(
      '#theme' => 'custom_block_display',
      '#weather' => $weather_data,
      '#attached' => array(
        'library' => ['d8_training/weather']
      )
    );
  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $city = $form_state->getValue('city_name');
    $this->setConfiguration(['city_name' => $city]);
  }
}

