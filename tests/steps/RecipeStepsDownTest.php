<?php

require_once "RecipeStepsTest.php";

class RecipeStepsDownTest extends RecipeStepsTest {
    
    
    protected function prepareRequest($stepId){
        $request = self::$client->post('steps/down.php?id='.$stepId, null, array());
        return $request;
    }
    
    
    public function testDownRecipeStep() {
        $response = $this->executeRequest(3, true);
        $this->verifyOk($response, 204);
        $this->verifyStepFromOrder(1, 3, "step4");
        $this->verifyStepFromOrder(1, 4, "step3");
    }
    
    
    public function testDownLastRecipeStep() {
        $response = $this->executeRequest(4, true);
        $this->verifyOk($response, 204);
        $this->verifyStepFromOrder(1, 4, "step4");
    }
    
    
    public function testDownRecipeStepNotFound(){
        $this->withNotFound(10);
    }
    
    
    public function testUpRecipeStepAccessDenied(){
        $this->withAcessDenied(1);
    }
    
}
?>
