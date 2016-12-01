<?php

namespace Drupal\d8_training;

use Drupal\Core\Config\ConfigFactory;
use GuzzleHttp\Client;
use Drupal\Component\Serialization\Json;
/**
 * Class OpenWeatherForecaster.
 *
 * @package Drupal\d8_training
 */
class OpenWeatherForecaster {
  private $config;
  private $baseUrl;
  private $http_client;
  /**
   * Constructor.
   */
  public function __construct(ConfigFactory $config, Client $http_client) {
    $this->config = $config;
    $this->http_client = $http_client;
    //$this->baseUrl = 'http://api.openweathermap.org/data/2.5/weather';
  }
  /**
   * Fetch weather data.
   */
  public function fetchWeatherData($city_name) {
    $api_key = $this->config->get('d8_training.configform');
    $api_key = $api_key->get('d8_config');
    $api_url = 'http://api.openweathermap.org/data/2.5/weather?q=' . $city_name . '&appid=2ae6e13f8875b87d47454e897e6da198';
    $response = $this->http_client->request('GET', $api_url, array('q' => $city_name, 'appid' => $api_key));
    $data = $response->getBody();
    $decoded = Json::decode($data);
    //print_r($decoded);
    /*$request->then(
      function ($response) {
        $data = 'I completed! ' . $res->getStatusCode() . $request->getBody();
      },
      function (RequestException $e) {
        $data = $e->getMessage() . "\n" . $e->getRequest()->getMethod();
      }
    );*/
    return $decoded;
  }

}
