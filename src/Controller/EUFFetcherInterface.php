<?php

namespace EUFTest\Controller;

/**
 * Interface EsnFetcherInterface.
 */
interface EUFFetcherInterface {

  /**
   * Performs a request to the endpoint provided to the API.
   *
   * @param string $endpoint
   *  The endpoint of the API we will perform the request to.
   *  Available $endpoint values: 'getCountries', 'getInstitutions'.
   *
   * @param array $params
   *  Array with additional parameters for the query in key=>value format.
   *  Available keys: CountryID
   *
   * @return string
   *   The response of the API call, in a JSON format.
   */
  public function getRequest($endpoint, $params = null);

  /**
   * Renders the data from the API request.
   *
   * @return string
   *   The HTML for the view.
   */
  public function render();

}
