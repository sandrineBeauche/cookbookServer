<?php

require_once "UnitTest.php";


class UnitUpdateTest extends UnitTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("units.yml", "users.yml"));
    }
    
    
    protected function prepareRequest($args = array()){
        return self::$client->post('units/update.php?id='.$args["id"], null, $args["values"]);
    }
    
    
    public function testUpdateUnit(){
        $args = array("name" => "anotherUnit");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyOk($response, 204);
        
        $unit = unitQuery::create()->findPk(1);
        $this->assertEquals("anotherUnit", $unit->getname());
    }
    
    public function testUpdateUnitExistingName(){
        $args = array("name" => "cl");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Cette unité existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateCountryBadName(){
        $args = array("name" => "");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateUnitAccessDenied(){
        $args = array("name" => "anotherCountry");
        $this->withAcessDenied(array("id" => 1, "values" => $args));
    }
    
    public function testUpdateUnitNotFound(){
        $args = array("name" => "anotherCountry");
        $this->withNotFound(array("id" => 10, "values" => $args), true);
    }
    
}

?>
