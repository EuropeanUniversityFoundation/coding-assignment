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
     * @param array $params
     *  Array with additional parameters for the query in key=>value format.
     *  Available keys: CountryID
     *
     * @return JSON
     *   The response of the API call, in a JSON format.
     */
    public function apiGetRequest($endpoint, $params = null);

}
