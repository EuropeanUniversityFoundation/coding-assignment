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
    protected $apiUrl = 'https://institutionsnew.herokuapp.com/'; //Development URL of institutions API

    /**
     * {@inheritdoc}
     */
    public function apiGetRequest($endpoint, $params = null)
    {
        //Build base URL
        $fullApiURL = $this->apiUrl . $endpoint;
        if (!is_null($params)){
            //Add parameters to URL
            $fullApiURL .= "?";
            foreach($params as $key=>$value){
                $fullApiURL .= $key."=".$value."&";
            }
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
