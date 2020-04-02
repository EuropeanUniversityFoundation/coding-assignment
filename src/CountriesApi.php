<?php

namespace EUFTest;

/**
 * Class CountriesApi.
 */
class CountriesApi  {

    /**
     * API url.
     *
     * @var string
     */
    protected $apiUrl = 'https://restcountries.eu/rest/v2/name/'; // REST Countries API

    /**
     * Does a GET request to the API to get some results.
     * This is what happens when you're too lazy to implement an Interface.
     * The code is adapted to match the syntax for the REST Countries API.
     *
     * @param string $countryName
     *  The primary argument of the API call.
     *
     * @param array $field
     *  Build query for one particular field.
     *
     * @return JSON
     *   The response of the API call, in a JSON format.
     */
    public function apiGetRequest($countryName, $field = null)
    {
        //Build base URL
        $fullApiURL = $this->apiUrl . $countryName;
        if (!is_null($field)){
            //Add field to URL
            $fullApiURL .= "?fields=" . $field;
        }
        $curl = curl_init($fullApiURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/x-www-form-urlencoded']);
        // Execute and get also the response code.
        $resp = curl_exec($curl);

        curl_close($curl);
        // We return the JSON directly, not an Array as may be needed.
        return $resp;
    }

}
