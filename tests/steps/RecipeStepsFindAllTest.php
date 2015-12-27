<?php

require_once "RecipeStepsTest.php";


class RecipeStepsFindAllTest extends RecipeStepsTest {
    
    protected function prepareRequest($recipeId){
        $request = self::$client->get('recipes/steps?recipeId='.$recipeId);
        return $request;
    }
    
    
    public function testFindAllRecipeSteps1() {
        $expectedJson = '[{"id": 1,"description":"step1"},
                          {"id": 2,"description":"step2"},
                          {"id": 3,"description":"step3"},
                          {"id": 4,"description":"step4"}]';
        
        $this->withJsonResult(1, $expectedJson);
    }
    
    public function testFindAllRecipeSteps2() {
        $expectedJson = '[]';
        
        $this->withJsonResult(3, $expectedJson);
    }
    
    public function testFindAllRecipeStepNotFound(){     
        $this->withNotFound(10, false);
    }
    
}
?>
