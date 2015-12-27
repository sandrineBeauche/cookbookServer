<?php

require_once "IngredientTypeTest.php";


class IngredientTypeUpdateTest extends IngredientTypeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("ingredientTypes.yml", "users.yml"));
    }
    
    
    protected function prepareRequest($args = array()){
        return self::$client->post('ingredientTypes/update.php?id='.$args["id"], null, $args["values"]);
    }
    
    
    public function testUpdateIngredientType(){
        $args = array("name" => "anotherIngredient");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyOk($response, 204);
        
        $ingredient = ingredientTypeQuery::create()->findPk(1);
        $this->assertEquals("anotherIngredient", $ingredient->getname());
    }
    
    public function testUpdateIngredientTypeExistingName(){
        $args = array("name" => "sucre");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Cet ingredient existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateIngredientTypeBadName(){
        $args = array("name" => "");
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateIngredientTypeAccessDenied(){
        $args = array("name" => "anotherIngredient");
        $this->withAcessDenied(array("id" => 1, "values" => $args));
    }
    
    public function testUpdateIngredientTypeNotFound(){
        $args = array("name" => "anotherIngredient");
        $this->withNotFound(array("id" => 10, "values" => $args), true);
    }
    
}

?>
