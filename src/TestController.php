<?php

namespace EUFTest;

use EUFTest\Controller\EUFFetcher;

/**
 * Class for the exercise.
 */
class TestController extends EUFFetcher {

	// Function for Task 3 first part
	// Returns an array with all country names and country ids
	public function fetchCountries(){
		
		$Countries = $this->getRequest('getCountries');
		
		$Countries = json_decode($Countries, true);
		
		return $Countries;
	}
	
	// Function for Task 3 second part
	// Returns an array with all institution data for one country id
	public function getInstsByCountryId($CountryId){
		
		$Insts = $this->getRequest('getInstitutions', array ('CountryID' => $CountryId));
		
		$Insts = json_decode($Insts, true);
		
		return $Insts;		
		
	}

	// Function for organizing the necessary data for the render() function
	private function groupInstsByCountryForRender(){
		
		$instsByCountries = $this->fetchCountries();
		
		for($i=0;$i<count($instsByCountries);$i++){
			
			$instsByCountries[$i]['Insts'] = array();
			
			$Insts = $this->getInstsByCountryId($instsByCountries[$i]['ID']);						
			
			// Getting the Country code from ErasmusCode by exploding first Institution's ErasmusCode belonging to a country
			// I might've missed something about how to get country codes for flags in an easier way
			$instsByCountries[$i]['Code'] = $this->erasmusCodeToIso(explode(" ", $Insts[0]['ErasmusCode'])[0]);
			
			foreach($Insts as $Inst){
				
				// Formats the Institutions (first letter of every word is uppercase) and adds (City name) to match the format on the sample picture
				$formattedInsts = ucwords(strtolower($Inst['NameInLatinCharacterSet'])) . ' (' . ucwords(strtolower($Inst['CityName'])) .')';
				array_push($instsByCountries[$i]['Insts'], $formattedInsts);
			}			
		}
		return($instsByCountries);
	}
	
	// Converting Country codes	from first letters of ErasmusCode of Institutions
	private function erasmusCodeToIso($erasmusCode){
		
		// Source: http://www.uvlf.sk/document/kody-krajin.pdf
		$codePairs = array (
						'A'=>'AT',
						'B'=>'BE',
						'CY'=>'CY',
						'CZ'=>'CZ',
						'DK'=>'DK',
						'EE'=>'EE',
						'SF'=>'FI',
						'F'=>'FR',
						'D'=>'DE',
						'G'=>'GR',
						'HU'=>'HU',
						'IRL'=>'IE',
						'I'=>'IT',
						'LV'=>'LV',
						'LT'=>'LT',
						'LUX'=>'LU',
						'MT'=>'MT',
						'NL'=>'NL',
						'P'=>'PT',
						'SK'=>'SK',
						'SI'=>'SI',
						'E'=>'ES',
						'S'=>'SE',
						'UK'=>'GB',
						'IS'=>'IS',
						'FL'=>'LI',
						'N'=>'NO',
						'BG'=>'BG',
						'PL'=>'PL',
						'RO'=>'RO',
						'TR'=>'TR',
						'IE'=>'IE',
						'RS'=>'RS',
						'LI'=>'LI',
						'HR'=>'HR',
						'MK'=>'MK',
						'CH'=>'CH'
					);		
		
		if(array_key_exists($erasmusCode, $codePairs)){
			$find       = array_keys($codePairs);		
			$replace    = array_values($codePairs);
			$isoCode = strtr($erasmusCode, $codePairs);
		} else {
			return 'xx';
		}
		
		return($isoCode);
	}
	
	// Task 5: Overwriting the original render() function. I'm not proud of the way I did that.	
	public function render(){
		$InstsByCountries = $this->groupInstsByCountryForRender();
		
		$html = '<div id="accordion">';
		
		for($i=0;$i<count($InstsByCountries);$i++){
			$html .= 	'<div class="card">
							<div class="card-header">								
								<a class="collapsed card-link" data-toggle="collapse" href="#collapse' . $i . '">';
			
			if(strtolower($InstsByCountries[$i]['Code']) == 'xx'){
				$html.= 			'<span style="padding-right:10px;" title="Erasmus Code of the Institutions may be misformatted, please check database!">
										<svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-patch-question" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
											<path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM8.05 9.6c.336 0 .504-.24.554-.627.04-.534.198-.815.847-1.26.673-.475 1.049-1.09 1.049-1.986 0-1.325-.92-2.227-2.262-2.227-1.02 0-1.792.492-2.1 1.29A1.71 1.71 0 0 0 6 5.48c0 .393.203.64.545.64.272 0 .455-.147.564-.51.158-.592.525-.915 1.074-.915.61 0 1.03.446 1.03 1.084 0 .563-.208.885-.822 1.325-.619.433-.926.914-.926 1.64v.111c0 .428.208.745.585.745z"/>
											<path fill-rule="evenodd" d="M10.273 2.513l-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
										</svg>
									</span>';
			} else {
				$html.= 			'<span class="flag-icon flag-icon-' . strtolower($InstsByCountries[$i]['Code']) . '"></span>';
			}
			
			$html.=					 $InstsByCountries[$i]['CountryName'] . ' (' . count($InstsByCountries[$i]['Insts']) .' universities)' .
						'		</a>
								
							</div>
							<div id="collapse' . $i . '" class="collapse" data-parent="#accordion">
								<div class="card-body small">';
			
			foreach($InstsByCountries[$i]['Insts'] as $Inst){
				$html .= 			$Inst . '<br>';
			}
			
			$html .=			'</div>
							</div>	
						</div>';
		}		
		$html .= '</div>';
		
		return $html;
	}
}
?>