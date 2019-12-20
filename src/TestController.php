<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {
    
    function getCountries(){
        $response = $this->getRequest("getCountries");
        $response = json_decode($response);
        return $response;
    }


    function getInstitutions($countryID){
        return $this->getRequest("getInstitutions", $countryID);
    }

    public function render()
    {
        include_once 'countryCodes.php';

        $html = '<div class="accordion" id="accordion">';

        $countries = $this->getCountries();
        $i = 1;
        foreach ($countries as $country){

            $institutions = json_decode($this->getInstitutions(array("CountryID" => $country->ID)));
            $html = $html . '<div class="card">';
            $html =  $html . '<div class="card-header" id="heading"' . $i .'>';
            $html = $html . '<h2 class="mb-0">';
            $html = $html . '<button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapse' . $i . '" aria-expanded="true" aria-controls="collapse' . $i . '">';
            $html = $html . '<span class="flag-icon flag-icon-' . strtolower(array_search($country->CountryName, $countrycodes)) . '"></span>' . $country->CountryName . " (" . count($institutions) . ' Universit' . (count($institutions)>1?"ies":"y") . ')';
            $html = $html . '</button></h2></div>';
            $html = $html . '<div id="collapse' . $i . '" class="collapse" aria-labelledby="heading' . $i . '" data-parent="#accordion">';
            $html = $html . '<div class="card-body">';


            foreach ($institutions as $institution){
                $html = $html . '<p>' . $institution->NameInLatinCharacterSet . ' (' . $institution->CityName . ')</p>';
            }
            $html = $html . '</div></div></div>';

            $i++;
        }

        $html = $html . '</div>';

        return $html;

    }
}