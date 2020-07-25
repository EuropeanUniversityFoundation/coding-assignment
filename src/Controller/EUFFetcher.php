<?php

namespace EUFTest\Controller;

/**
 * Class EUFFetcher.
 */
class EUFFetcher implements EUFFetcherInterface {

  /**
   * InstitutionsAPI object.
   *
   * @var InstitutionsApiInterface
   */
  public $api = NULL;

  /**
   * Contructor.
   */
  public function __construct() {
    // We load here the models that are needed.
    $this->api = new InstitutionsApi();
  }

  /**
   * {@inheritdoc}
   */
  public function getRequest($endpoint, $params = null) {
    $resp = $this->api->apiGetRequest($endpoint, $params);
    return $resp;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $html  = '<div>You need to overwrite this output in your class file with your own render().</div>';
    $html .= '<div class="hints alert alert-success" role="alert">Random fact: Manneken Pis is one of the most famous landmarks in Brussels, while only being 61 cm tall.</div>';

    return $html;
  }

}
