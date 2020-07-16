<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */

class TestController extends EUFFetcher
{

public function RetrieveCountries()
{
    $json = $this->api->apiGetRequest("getCountries", null);

    $array = json_decode($json, true);

    return $array['CountryName'];
}

public function RetrieveCountryRecords()
{
    $json = $this->api->apiGetRequest("getCountries", null);

    $array = json_decode($json, true);

    return $array;
}

public function RetrieveUniversities($countryID)
{
    $params['CountryID'] = $countryID;

    $json = $this->api->apiGetRequest("getInstitutions", $params);

    $array = json_decode($json, true);

    return array_column($array, 'NameInLatinCharacterSet');
}

private function NationalFlag($cid)
{
    $flagmap['2'] = "aw";
    $flagmap['1'] = "at";
    $flagmap['3'] = "be";
    $flagmap['4'] = "bg";
    $flagmap['18'] = "hr";
    $flagmap['6'] = "cy";
    $flagmap['39'] = "cw";
    $flagmap['7'] = "cz";
    $flagmap['9'] = "dk";
    $flagmap['10'] = "ee";
    $flagmap['12'] = "fi";
    $flagmap['27'] = "mk";
    $flagmap['13'] = "fr";
    $flagmap['15'] = "gi";
    $flagmap['17'] = "gr";
    $flagmap['16'] = "gl";
    $flagmap['19'] = "hu";
    $flagmap['21'] = "is";
    $flagmap['20'] = "ir";
    $flagmap['22'] = "it";
    $flagmap['26'] = "lv";
    $flagmap['23'] = "li";
    $flagmap['24'] = "lt";
    $flagmap['25'] = "lu";
    $flagmap['28'] = "mt";
    $flagmap['30'] = "nl";
    $flagmap['29'] = "nc";
    $flagmap['31'] = "no";
    $flagmap['32'] = "pl";
    $flagmap['33'] = "pt";
    $flagmap['34'] = "ro";
    $flagmap['40'] = "sb";
    $flagmap['37'] = "sk";
    $flagmap['36'] = "si";
    $flagmap['11'] = "es";
    $flagmap['35'] = "se";
    $flagmap['5'] = "ch";
    $flagmap['38'] = "tr";
    $flagmap['14'] = "gb";
    $flagmap['8'] = "de";

    return $flagmap[$cid] ?? 'xx';
}

public function render()
{
    $html = '<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">';

    $crecords = $this->RetrieveCountryRecords();

    foreach($crecords as $record)
    {
        $country = $record['CountryName'];
        $cid = $record['ID'];
        $universities = $this->RetrieveUniversities($cid);
        $flag = $this->NationalFlag($cid);

        $html .= '<div class="panel panel-default">';
        $html .= '<div class="panel-heading" role="tab" id="heading'.$cid.'">';
        $html .= '<h4 class="panel-title">';
        $html .= '<span class="flag-icon flag-icon-'.$flag.'"></span>';

        $html .= '<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse'.$cid.'" aria-expanded="false" aria-controls="collapse'.$cid.'">';
        $html .= $country.' ('.count($universities).' Universities)';
        $html .= '</a></h4></div>';

        foreach($universities as $univ)
        {
            $html .= '<div id="collapse'.$cid.'" class="panel-collapse collapse " role="tabpanel" aria-labelledby="heading'.$cid.'">';
            $html .= '<div class="panel-body">';
            $html .= $univ;
            $html .='</div></div></div>';
        }
    }

    $html .= '</div>';
    
    return $html;
}

}
