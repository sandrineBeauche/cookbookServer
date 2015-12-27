<?php

require_once "RecipeStepsTest.php";

class RecipeStepsUpdateTest extends RecipeStepsTest {
    
   
    protected function prepareRequest($args){
        $request = self::$client->post('steps/update.php?id='.$args["stepId"], null, array(
            'description' => $args["description"]
        ));
        return $request;
    }
    
    
    public function testUpdateRecipeStep(){
        $args = array("stepId" => 1, "description" => "go!");
        $response = $this->executeRequest($args, true);
        $this->verifyOk($response, 204);
        
        $this->verifyStep(1, "go!");
    }
    
    
    public function testUpdateRecipeStepNotFound(){
        $args = array("stepId" => 10, "description" => "go!");
        $this->withNotFound($args, true);
    }
    
    
    public function testUpdateRecipeAccessDenied(){
        $args = array("stepId" => 1, "description" => "go!");
        $this->withAcessDenied($args);
    }
    
}
?>
