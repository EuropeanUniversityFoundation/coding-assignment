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
   *  Note: Endpoint names are case sensitive!
   *  Available $endpoint value for getting a list of Countries:
   *  - 'Countries'
   *
   *  Available $endpoint values for Institutions in a Country:
   *  - Country ISO Code (iso_code) values in the response of the 'Countries' endpoint.
   *  - For example: $endpoint value for getting Institutions in Luxembourg: 'LU'
   *
   * @return string
   *   The response of the API call, in a JSON format.
   *
   */
  public function getRequest($endpoint);

  /**
   * Renders the data from the API request.
   *
   * @return string
   *   The HTML for the view.
   */
  public function render();

}
