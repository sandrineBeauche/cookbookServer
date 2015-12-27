<?php

require_once "CountryTest.php";


class CountryCreateTest extends CountryTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("countries.yml", "users.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        return self::$client->post('countries/create.php', null, $args);
    }
    
     
    public function testCreateCountry(){
        $args = array("name" => "newCountry", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest($args, true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = countryQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("newCountry", $created->getname());
        $this->assertEquals("http://www.drapeauxdespays.fr/data/flags/mini/sm.png", $created->getflag());
    }
    
    
    public function testCreateCountryAccessDenied(){
        $args = array("name" => "newCountry", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $this->withAcessDenied($args);
    }
    
    
    public function testCreateCountryExistingName(){
        $args = array("name" => "France", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Ce pays existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateCountryBadName(){
        $args = array("name" => "", "flag" => "http://www.drapeauxdespays.fr/data/flags/mini/sm.png");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
   
    
}

?>
