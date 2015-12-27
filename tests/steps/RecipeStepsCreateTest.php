<?php

require_once "RecipeStepsTest.php";

class RecipeStepsCreateTest extends RecipeStepsTest {
    
    protected function prepareRequest($args){
        $request = self::$client->post('recipes/steps/create.php?recipeId='.$args["recipeId"], null, array(
            'description' => $args["description"]
        ));
        return $request;
    }
    
    
    public function testCreateRecipeStep() {
        $args = array("recipeId" => 1, "description" => "nouvelle etape");
        $response = $this->executeRequest($args, true);
        $this->verifyOk($response);
        $this->verifyStepFromOrder(1, 5, "nouvelle etape");
    }
    
    public function testCreateRecipeStepAccessDenied(){
        $this->withAcessDenied(array("recipeId" => 1, "description" => "nouvelle etape"));
    }
    
    
    public function testCreateRecipeStepNotFound(){    
        $this->withNotFound(array("recipeId" => 10, "description" => "nouvelle etape"), true);
    }
}
?>
