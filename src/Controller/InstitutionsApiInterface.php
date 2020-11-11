<?php

namespace EUFTest\Controller;

/**
 * Interface EsnApiInterface.
 */
interface InstitutionsApiInterface {

  /**
   * Does a GET request to the API to get some results.
   *
   * @param string $endpoint
   *  The endpoint of the API we will perform the request to.
   *  Available $endpoint values: 'getCountries', 'getInstitutions'.
   *
   * @param int $param
   *  Additional parameter for the query.
   *  Available to pass Country ID value for the 'getInstitutions' endpoint.
   *
   * @return JSON
   *   The response of the API call, in a JSON format.
   */
  public function apiGetRequest($endpoint, $param = null);

}
