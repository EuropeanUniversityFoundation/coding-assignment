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
   * @param int $param
   *  Additional parameter for the query.
   *  Available to pass Country ID value for the 'getInstitutions' endpoint.
   *
   * @return string
   *   The response of the API call, in JSON format.
   */
  public function getRequest($endpoint, $param = null);

  /**
   * Renders the data from the API request.
   *
   * @return string
   *   The HTML for the view.
   */
  public function render();

}
