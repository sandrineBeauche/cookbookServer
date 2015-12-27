<?php

require_once "IngredientTypeTest.php";


class IngredientTypeDeleteTest extends IngredientTypeTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("ingredients.yml", 
                                             "users.yml", 
                                             "ingredientTypes.yml"));
    }
    
    
    protected function prepareRequest($args){
        $url = 'ingredientTypes/delete.php?id='.$args["id"];
        if(array_key_exists("force", $args)){
            $url = $url."&force=".$args["force"];
        }
        return self::$client->get($url);
    }
    
    
    public function testDeleteIngredientType(){
        $response = $this->executeRequest(array("id" => 4), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$IngredientTypeQuery, 4);
    }
    
    
    public function testDeleteIngredientTypeWithForeign(){
        $response = $this->executeRequest(array("id" => 2), true);
        
        $this->verifyOk($response, 200);
        $this->verifyDatabaseNoChange();
        $result = $response->json();
        $this->assertEquals("Cet ingredient est référencée dans les ingredients de recette.", $result["result"]);
    }
    
    
    public function testDeleteIngredientTypeWithForeignForce(){
        $response = $this->executeRequest(array("id" => 2, "force" => "true"), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$IngredientTypeQuery, 2);
        $this->assertNull(ingredientQuery::create()->findPk(2));
    }
    
    
    public function testDeleteIngredientTypeAccessDenied(){
        $this->withAcessDenied(array("id" => 1));
    }
    
    public function testDeleteIngredientTypeNotFound(){
        $this->withNotFound(array("id" => 10), true);
    }
   
}

?>
