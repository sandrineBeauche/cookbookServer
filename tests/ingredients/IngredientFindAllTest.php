<?php

require_once "IngredientTest.php";


class IngredientFindAllTest extends IngredientTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "ingredients.yml", "units.yml", "ingredientTypes.yml"));
    }
    
    protected function prepareRequest($args){
        $request = self::$client->get('recipes/ingredients?recipeId='.$args);
        return $request;
    }
    
    public function testFindAllIngredients() {
        $expectedJson = '[{"id":"1","quantity":"50","ingredient":"sucre","unit":"gr"},
                          {"id":"2","quantity":"20","ingredient":"lait","unit":"cl"}]';
        
        $this->withJsonResult(1, $expectedJson);
    }
    
    public function testFindAllIngredientNotFound(){
        $this->withNotFound(10);
    }
}

?>
