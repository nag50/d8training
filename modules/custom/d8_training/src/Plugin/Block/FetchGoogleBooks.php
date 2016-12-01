<?php

namespace Drupal\d8_training\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use AntoineAugusti\Books\Fetcher;
use GuzzleHttp\Client;

/**
 * Provides a 'FetchGoogleBooks' block.
 *
 * @Block(
 *  id = "fetch_google_books",
 *  admin_label = @Translation("Fetch google books"),
 * )
 */
class FetchGoogleBooks extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form['book_isbn'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('ISBN'),
      '#description' => $this->t('ISBN value of the book for which we fetch the details'),
      '#default_value' => isset($this->configuration['book_isbn']) ? $this->configuration['book_isbn'] : '',
      '#maxlength' => 60,
      '#size' => 40,
      '#weight' => '0',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->configuration['book_isbn'] = $form_state->getValue('book_isbn');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    $client = new Client(['base_uri' => 'https://www.googleapis.com/books/v1/']);
    $fetcher = new Fetcher($client);
    $book = $fetcher->forISBN($this->configuration['book_isbn']);
    $build['fetch_google_books_block_field']['#markup'] = '<p>' . $book->title . '</p>';

    return $build;
  }

}
