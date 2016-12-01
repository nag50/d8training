<?php

namespace Drupal\d8_training\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
/**
 * Class EventManager.
 *
 * @package Drupal\d8_training
 */
class EventManager implements EventSubscriberInterface{
  /**
   * Constructor.
   */
  public function __construct() {

  }

  public static function getSubscribedEvents() {
    $events[KernelEvents::RESPONSE][] = array('addHeaders');
    return $events;
  }

  public function addHeaders(FilterResponseEvent $event) {
    $response = $event->getResponse();
    $response->headers->add(['Access-Control-Allow-Origin' => '*']);
  }
}
