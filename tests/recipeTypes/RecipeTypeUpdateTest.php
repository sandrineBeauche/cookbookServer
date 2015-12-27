<?php

require_once "RecipeTypeTest.php";


class RecipeTypeUpdateTest extends RecipeTypeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("countries.yml", "users.yml"));
    }
    
    
    protected function prepareRequest($args = array()){
        return self::$client->post('countries/update.php?id='.$args["id"], null, $args["values"]);
    }
    
    
    public function testUpdateCountry(){
        $args = array("name" => "anotherCountry", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyOk($response, 204);
        
        $country = countryQuery::create()->findPk(1);
        $this->assertEquals("anotherCountry", $country->getname());
        $this->assertEquals("http://www.drapeauxdespays.fr/data/flags/mini/sm.png", $country->getflag());
    }
    
    public function testUpdateCountryExistingName(){
        $args = array("name" => "Tunisie", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Ce pays existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateCountryBadName(){
        $args = array("name" => "", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateCountryAccessDenied(){
        $args = array("name" => "anotherCountry", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $this->withAcessDenied(array("id" => 1, "values" => $args));
    }
    
    public function testUpdateCountryNotFound(){
        $args = array("name" => "anotherCountry", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $this->withNotFound(array("id" => 10, "values" => $args), true);
    }
    
}

?>
