<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;
use EUFTest\CountriesApi;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {

  /**
   * Performs a GET request to the endpoint 'getCountries'
   *
   * @return array $arrayCountries
   *  Array of Countries decoded from JSON
   */
  public function getCountries() {

    $jsonResponse = $this->getRequest('getCountries');
    $countryObjects = json_decode($jsonResponse);
    // Convert the array of objects into a carefully crafted associative array
    $arrayCountries = array();
    foreach ($countryObjects as $key => $object) {
      $arrayCountries[$object->CountryName] = array('ID' => $object->ID, 'CountryCode' => '', 'Institutions' => array(), 'Count' => null);
    }
    // Fetch the country code
    foreach ($arrayCountries as $key => &$array) {
      $array['CountryCode'] = $this->getCountryCode($key);
    }

    return $arrayCountries;
  }

  /**
   * Performs a GET request to the REST Countries API
   *
   * @param string $countryName
   *  Name of the country to be looked up
   * @return string $countryCode
   *  Two-letter code for the country
   */
  public function getCountryCode($countryName) {

    // Hard coded exception handling FTW!
    if ($countryName == "Former Yugoslav Republic of Macedonia") {
      // this part is debatable...
      $countryName = "Macedonia";
    }

    $api = new CountriesApi();

    $jsonResponse = $api->apiGetRequest($countryName, 'alpha2Code');
    $responseArray = json_decode($jsonResponse, TRUE);
    foreach ($responseArray as $response) {
      foreach ($response as $key => $value) {
        $alpha2Code = $value;
      }
    }
    $countryCode = strtolower($alpha2Code);

    return $countryCode;
  }

  /**
   * Performs a GET request to the endpoint 'getInstitutions'
   *
   * @param string $countryId
   *  It could be an integer, but let's face it, who cares?
   *
   * @return array $arrayInstitutions
   *  Array of Institutions decoded from JSON
   */
  public function getInstitutions($countryId) {

    $jsonResponse = $this->getRequest('getInstitutions', ['CountryID' => $countryId]);
    // The normal associative array will suffice in this case.
    $arrayInstitutions = json_decode($jsonResponse, TRUE);
    // Clean up the uppercase
    foreach ($arrayInstitutions as &$item) {
      $item['NameInLatinCharacterSet'] = ucwords(strtolower($item['NameInLatinCharacterSet']));
    }

    return $arrayInstitutions;
  }

  /**
   * Builds the complete list of Institutions by Country
   *
   */
  public function buildList() {

    // Get the list of Countries
    $completeList = $this->getCountries();

    // Get the list of Institutions for each Country
    foreach ($completeList as $key => &$array) {
      $array['Institutions'] = $this->getInstitutions($array['ID']);
      $array['Count'] = sizeof($array['Institutions']);
    }

    return $completeList;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    //$html  = '<div>You need to overwrite this output in your class file with your own render().</div>';
    //$html .= '<div class="hints alert alert-success" role="alert">Random fact: I don\'t care.</div>';

    $countryList = $this->buildList();

    // returning HTML is ugly!
    return $countryList;
  }

}
