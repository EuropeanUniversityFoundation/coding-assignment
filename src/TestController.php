<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {

	/**
	 * Get the list of countries
	 *
	 * @return array
	 *   The list of countries
	 *
	 */
	public function getAllCountries() {
		return json_decode( parent::getRequest('getCountries'), true );;
	}

	/**
	 * Get the list of universities by CountryID
	 *
	 * @return array
	 *   The list of universities
	 *
	 */
	public function getUniversitiesByID($countryID) {
		return json_decode( parent::getRequest('getInstitutions', array("CountryID" => $countryID)), true );
	}

	/**
	 * Renders list of universities.
	 *
	 * @return string
	 *   The HTML for the view.
	 */
	private function renderUniversities($universities, $ID) {
		$html = "";
		foreach($universities as $u){
			$html .= "<div id=\"collapse".$ID."\" class=\"panel-collapse collapse\">";
			$html .= "<div class=\"card-body\">".$u["NameInLatinCharacterSet"]." (".$u["CityName"].")</div>";
			$html .= "</div>";
		}
		return $html;
	}

	/**
	 * Renders the data from the API request.
	 *
	 * @return string
	 *   The HTML for the view.
	 */
	public function render() {

    	$countries = $this->getAllCountries();

    	$html = "";
    	foreach($countries as $value){
    		$universities = $this->getUniversitiesByID($value["ID"]);
    		$number = count($universities);
    		$html .= "<div class=\"card\" style=\"margin-bottom: 5px;\">";
    		
    		$html .= "<div class=\"card-header\">";
    		$html .= "<a data-toggle=\"collapse\" href=\"#collapse".$value["ID"]."\">";
    		$html .= $value["CountryName"]." (".$number . ($number == 1 ? " university)" : " universities)");
    		$html .= "</a>";
    		$html .= "</div>";

    		$html .= $this->renderUniversities($universities, $value["ID"]);
    		
    		$html .= "</div>";
    	}

    	return $html;
  	}

}
