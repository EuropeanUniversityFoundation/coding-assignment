<?php

namespace EUFTest\Controller;

/**
 * Class EUFFetcher.
 */
class EUFFetcher implements EUFFetcherInterface {

  /**
   * InstitutionsAPI object.
   *
   * @var InstitutionsApiInterface
   */
  public $api = NULL;

  /**
   * Contructor.
   */
  public function __construct() {
    // We load here the models that are needed.
    $this->api = new InstitutionsApi();
  }

  /**
   * {@inheritdoc}
   */
  public function getRequest($endpoint, $params = null) {
    $resp = $this->api->apiGetRequest($endpoint, $params);
    return $resp;
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
     
//MY CODE:
    $url = 'own.json'; // path to my own JSON file, not API's one
    $data = file_get_contents($url); // contents into a variable
    $characters = json_decode($data,true); // decode
    
    $html  = '<div><b>These are all the contries in my own.json file:</b></div>';
    foreach ($characters as $character) {
    $a = $character['country']. '<br>';
    $html .= '<h4>' . $a . '</h4>';//output of all the countries (2)
    }
    
    $html .= '<div><b>Universities in Belgium:</b></div>';
    foreach ($characters as $character) {    
    $a = $character['universities'][0]. '<br>';  
    $html .= '<h4>' . $a . '</h4>';//output of Belgian universities
    }
     
    $html .= '<div><b>Universities in Spain:</b></div>';
    foreach ($characters as $character) {    
    $a = $character['universities'][1]. '<br>';  
    $html .= '<h4>' . $a . '</h4>';//output of Spanish universities
    }
        
    //$html  = '<div>You need to overwrite this output in your class file with your own render().</div>';
    $html .= '<div class="hints alert alert-success" role="alert">Random fact: Manneken Pis is one of the most famous landmarks in Brussels, while only being 61 cm tall.</div>';
    
return $html;
    
}}

    $url = 'own.json';
    $data = file_get_contents($url);
    $characters = json_decode($data,true);
    
?>

<div class="accordion" id="accordionExample275">
    
  <div class="card z-depth-0 bordered">
      
    <div class="card-header" id="headingOne2">
      <h5 class="mb-0">
        <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne2"
          aria-expanded="true" aria-controls="collapseOne2">
           
            <span class="flag-icon flag-icon-be"></span>   
            Belgium (2 Universities)
        </button>
      </h5>
    </div>
      
    <div id="collapseOne2" class="collapse" aria-labelledby="headingOne2"
      data-parent="#accordionExample275">
      <div class="card-body">
        <?php
            foreach ($characters as $character) {    
            $a = $character['universities'][0]. '<br>';  
            echo $a;
            }
        ?>
      </div>
    </div>
      
  </div>
    
  <div class="card z-depth-0 bordered">
      
    <div class="card-header" id="headingTwo2">        
      <h5 class="mb-0">
        <button class="btn btn-link collapsed" type="button" data-toggle="collapse"
          data-target="#collapseTwo2" aria-expanded="false" aria-controls="collapseTwo2">
            <span class="flag-icon flag-icon-es"></span>
            Spain (2 Universities)
        </button>
      </h5>
    </div>
      
    <div id="collapseTwo2" class="collapse" aria-labelledby="headingTwo2"
      data-parent="#accordionExample275">
      <div class="card-body">
        <?php
            foreach ($characters as $character) {    
            $a = $character['universities'][1]. '<br>';  
            echo $a;
            }
        ?>
      </div>
    </div>
      
  </div>
    
</div>
