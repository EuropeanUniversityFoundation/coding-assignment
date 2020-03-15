<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {
    // Returns a 2D array of the countries from JSON data from the institutions API. Subarrays' keys are: 'CountryName' and 'ID'
    function getCountries() {
       $json =  EUFFetcher::getRequest('getCountries');
       $countriesArray = json_decode($json, true);
        return $countriesArray;
    }

    // Provided the 'ID' of a certain country from the array getCountries() returns, and returns a 2D array from JSON data from the institutions API. Subarrays' keys are: 'CityName', 'ErasmusCode', 'NameInLatinCharacterSet'
    function getUnis($value) {
        $countryID = array("CountryID"=>$value);
        $json = EUFFetcher::getRequest('getInstitutions', $countryID);
        $institutesOfCountry = json_decode($json, true);
        return $institutesOfCountry;
    }
    

    // Provided the array of universities of a country, returns a string with the HTML of the list of universities
    function cardUnisList($unisArray){
        $cardUnisList = [];
        for ($i = 0; $i < sizeof($unisArray); $i++) {
            $cardUnisList[$i] = "<li>{$unisArray[$i]['NameInLatinCharacterSet']} ({$unisArray[$i]['CityName']})</li>";
        }
        $uniString = implode($cardUnisList);
        return $uniString;
    }

    // Provided a particular country, it returns the string with the HTML of the .card div of the country
    function cardRender($country) {
        $unisArray = $this->getUnis($country['ID']);
        $unisArraySize = strval(sizeof($unisArray));

        $propString = substr($country['CountryName'], 0, 5);

        $htmlCard = "<div class=\"card\">
                        <div class=\"card-header\" id=\"heading{$propString}\">
                            <h5 class=\"mb-0\">
                                <button class=\"btn btn-link\" data-toggle=\"collapse\" aria-expanded=\"true\" data-target=\"#collapse{$propString}\" aria-controls=\"collapse{$propString}\">
                                <span>{$country['CountryName']}</span> <span>({$unisArraySize} universities)</span>
                                </button>
                            </h5>
                        </div>
                    
                        <div id=\"collapse{$propString}\" class=\"collapse\" aria-labelledby=\"heading{$propString}\" data-parent=\"#accordion\">
                            <div class=\"card-body\">
                                <ul>
                                    {$this->cardUnisList($unisArray)}
                                </ul>
                            </div>
                        </div>
                    </div>";
      return $htmlCard;
    }

    // Provided the array of countries, returns a string with the HTML of all the .card divs that has to be rendered in the #accordion div
    function allCardsString($countries){
        $allCardsList = [];
        for($i = 0; $i < sizeof($countries); $i++){
            $allCardsList[$i] = $this->cardRender($countries[$i]);
        }
        $allCardsString = implode($allCardsList);
        return $allCardsString;
    }

    // render() function overrided
    function render() {
        $countries = $this->getCountries();
        $htmlContainAccordion = '<div id="accordion">' . $this->allCardsString($countries) . '</div>';
        return $htmlContainAccordion; 
    }
}
