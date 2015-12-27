<?php

require_once "IngredientTest.php";


class IngredientFindOneTest extends IngredientTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "units.yml", "ingredientTypes.yml", "ingredients.yml"));
    }
    
    protected function prepareRequest($id) {
        return self::$client->get('ingredients/findOne.php?id='.$id);
    }

    public function testFindIngredient(){
        $expectedJson = '{"id":1,"quantity":50,"unitId":1,"ingredientId":3,"recipeId":1}';
        
        $this->withJsonResult(1, $expectedJson);
    }

    public function testFindIngredientNotFound(){
        $this->withNotFound(10);
    }
    
}

?>
