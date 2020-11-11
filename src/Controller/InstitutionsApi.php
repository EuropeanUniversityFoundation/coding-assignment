<?php

namespace EUFTest\Controller;

/**
 * Class EsnApi.
 */
class InstitutionsApi implements InstitutionsApiInterface {

    /**
     * API url.
     *
     * @var string
     */
    protected $apiUrl = 'https://hei.dev.uni-foundation.eu/heiapi/legacy/'; //Development URL of institutions API

    /**
     * {@inheritdoc}
     */
    public function apiGetRequest($endpoint, $param = null)
    {
        //Build base URL
        $fullApiURL = $this->apiUrl . $endpoint;

        if (!is_null($param)){
            //Add parameter to URL
            $fullApiURL .= "/";
            $fullApiURL .= $param;
        }

        $curl = curl_init($fullApiURL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Accept: application/json', 'Content-Type: application/vnd.api+json']);

        // Execute and get also the response code.
        $resp = curl_exec($curl);

        curl_close($curl);
        // We return the JSON directly, not an Array as may be needed.
        return $resp;
    }

}
