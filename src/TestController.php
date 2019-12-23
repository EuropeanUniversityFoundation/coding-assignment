<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {

    public $ISO2AlphaArray= NULL;

    /**
     * Contructor.
     */
    public function __construct() {
        parent::__construct();

        $country_names = json_decode(
            file_get_contents("http://country.io/names.json")
        , true);
        $this->ISO2AlphaArray = array_flip($country_names);
    }

    /**
     * Performs a fetch of all the Countries in the API.
     *
     * @return Array [ (@string 'CountryName', @int ID)]
     *   The response of the API call, in an Array format.
     */
    public function fetchAllCountries(){
        $answ = $this->getRequest('getCountries',null);
        $to_array = json_decode($answ,true);
        return $to_array; 
    }

    /**
     * Performs a request of the Universities of the $ID to the API.
     *
     *
     * @param string $countryName
     *  Array with additional parameters for the query in key=>value format.
     *  Available keys: CountryID
     *
     * @return string
     *   The response of the API call, in an Array format.
     */
    public function fetchUniversities($countryName)
    {
        $availableCountry = $this->fetchAllCountries();
        $ID = null;
        foreach( $availableCountry as $test)
        {
            if($test['CountryName'] === $countryName ){
                $ID = $test['ID'] ;}
        }
        //to express better
        if($ID === null) {return '';}

        $param = array('CountryID'=>$ID);

        $answ = $this->getRequest('getInstitutions',$param);
        $to_array = json_decode($answ,true);
        return $to_array;      
    }

    /**
     * {@inheritdoc}
     */

    
    public function render() {
        
        $html  = '<div class="accordion md-accordion" role="tablist" id="accordion" aria-multiselectable="true">';
        $availableCountry = $this->fetchAllCountries();
        
        //for each template
        foreach( $availableCountry as $country)
        {
            $country_name = $country['CountryName'];
            //found the flag
            $flag = null;
            if($country_name=='Former Yugoslav Republic of Macedonia') {$flag='mk';}
            else if($country_name=='Curaçao') {$flag='cw';}
            else {$flag = strtolower($this->ISO2AlphaArray[$country_name]);}



            //take the universities
            $universities = $this->fetchUniversities($country_name);            
            $numberofUniversities=strval(sizeof($universities));


            $id_country_name = preg_replace('/\s+/', '_', $country_name);

            //make a card with a collapsable area with bootstrap
            $html .= '<div class="card"> <div class="card-header" role="tab" id="heading'.$id_country_name.'">';
            $html .='<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$id_country_name.'" aria-expanded="false" aria-controls="collapse'.$id_country_name.'"> <h5 class="mb-0">';
          
            //to change

            

            $html .= '<span class="flag-icon flag-icon-'.$flag.' flag-icon-squared"></span>';
            $html .= $country_name.'  ('.$numberofUniversities.' universities) <i class="fas fa-angle-down rotate-icon"></i>';

            $html .='</h5> </a> </div>';

            $html .='<div id="collapse'.$id_country_name.'" class="collapse" role="tabpanel" aria-labelledby="heading'.$id_country_name.'" data-parent="#accordion"> <div class="card-body">';
            //fetch the universities
            
            foreach($universities as $university)
            {
                $html .='<br/>' ;
                $html .= $university['NameInLatinCharacterSet'].' ('.$university['CityName'].')';
            }
            

            $html .= ' </div> </div> </div>';
        }
        $html  .= '</div>';

        return $html;
        

    }
    
}
