<?php

require_once "RecipeStepsTest.php";


class RecipeStepsFindOneTest extends RecipeStepsTest {
    
    protected function prepareRequest($args){
        $url = 'recipes/steps/findOne.php?recipeId='.$args["recipeId"].'&id='.$args["order"];
        $request = self::$client->get($url);
        return $request;
    }
    
    public function testFindOneRecipeStep() {
        $expectedJson = '{"id": 5,"description":"step5", "order": 1}';
        $this->withJsonResult(array("recipeId" => 2, "order" => 1), $expectedJson);
    }
    
    
    public function testFindOneRecipeStepNotFound() {   
        $this->withNotFound(array("recipeId" => 2, "order" => 5), false);
    }
    
}
?>
