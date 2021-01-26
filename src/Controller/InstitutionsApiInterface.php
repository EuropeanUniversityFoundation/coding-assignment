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
     *  Note: Endpoint names are case sensitive!
     *  Available $endpoint values: 'Countries' and the values of [iso_code] fetched from the Countries endpoint.
     *  e.g. endpoint for Luxembourg: 'LU'
     *
     * @return JSON
     *   The response of the API call, in a JSON format.
     */
    public function apiGetRequest($endpoint);

}
