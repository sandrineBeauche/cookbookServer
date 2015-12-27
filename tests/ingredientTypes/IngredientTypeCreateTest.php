<?php

require_once "IngredientTypeTest.php";


class IngredientTypeCreateTest extends IngredientTypeTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("ingredientTypes.yml", "users.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        return self::$client->post('ingredientTypes/create.php', null, $args);
    }
    
     
    public function testCreateIngredientType(){
        $args = array("name" => "newIngredient");
        $response = $this->executeRequest($args, true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = ingredientTypeQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("newIngredient", $created->getname());
    }
    
    
    public function testCreateIngredientTypeAccessDenied(){
        $args = array("name" => "newIngredient");
        $this->withAcessDenied($args);
    }
    
    
    public function testCreateIngredientTypeExistingName(){
        $args = array("name" => "sucre");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Cet ingredient existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateIngredientTypeBadName(){
        $args = array("name" => "");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
   
    
}

?>
