<?php

require_once "RecipeStepsTest.php";

class RecipeStepsUpTest extends RecipeStepsTest {
    
    protected function prepareRequest($stepId){
        $request = self::$client->post('steps/up.php?id='.$stepId, null, array());
        return $request;
    }
    
    
    public function testUpRecipeStep() {
        $response = $this->executeRequest(3, true);
        $this->verifyOk($response, 204);
        $this->verifyStepFromOrder(1, 2, "step3");
        $this->verifyStepFromOrder(1, 3, "step2");
    }
    
    
    public function testUpFirstRecipeStep() {
        $response = $this->executeRequest(1, true);
        $this->verifyOk($response, 204);
        $this->verifyStepFromOrder(1, 1, "step1");
    }
    
    
    public function testDownRecipeStepNotFound(){
        $this->withNotFound(10, true);
    }
    
    
    public function testDownRecipeStepAccessDenied(){
        $this->withAcessDenied(1);
    }
    
}
?>
