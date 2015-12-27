<?php

require_once "IngredientTest.php";


class IngredientDeleteTest extends IngredientTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("ingredients.yml", 
                                             "users.yml"));
    }
    
    
    protected function prepareRequest($args){
        $url = 'ingredients/delete.php?id='.$args["id"];
        return self::$client->get($url);
    }
    
    
    public function testDeleteIngredient(){
        $response = $this->executeRequest(array("id" => 1), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$IngredientQuery, 1);
    }
    
    
    public function testDeleteIngredientAccessDenied(){
        $this->withAcessDenied(array("id" => 1));
    }
    
    public function testDeleteIngredientNotFound(){
        $this->withNotFound(array("id" => 10), true);
    }
   
}

?>
