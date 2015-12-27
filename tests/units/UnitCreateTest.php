<?php

require_once "UnitTest.php";


class UnitCreateTest extends UnitTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("units.yml", "users.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        return self::$client->post('units/create.php', null, $args);
    }
    
     
    public function testCreateUnit(){
        $args = array("name" => "newUnit");
        $response = $this->executeRequest($args, true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = unitQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("newUnit", $created->getname());
    }
    
    
    public function testCreateUnitAccessDenied(){
        $args = array("name" => "newUnit");
        $this->withAcessDenied($args);
    }
    
    
    public function testCreateUnitExistingName(){
        $args = array("name" => "gr");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Cette unité existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateUnitBadName(){
        $args = array("name" => "");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
   
    
}

?>
