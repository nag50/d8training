<?php

namespace Drupal\drupal_console_gen\Tests;

use Drupal\simpletest\WebTestBase;

/**
 * Provides automated tests for the drupal_console_gen module.
 */
class DefaultControllerTest extends WebTestBase {
  /**
   * {@inheritdoc}
   */
  public static function getInfo() {
    return array(
      'name' => "drupal_console_gen DefaultController's controller functionality",
      'description' => 'Test Unit for module drupal_console_gen and controller DefaultController.',
      'group' => 'Other',
    );
  }

  /**
   * {@inheritdoc}
   */
  public function setUp() {
    parent::setUp();
  }

  /**
   * Tests drupal_console_gen functionality.
   */
  public function testDefaultController() {
    // Check that the basic functions of module drupal_console_gen.
    $this->assertEquals(TRUE, TRUE, 'Test Unit Generated via App Console.');
  }

}
