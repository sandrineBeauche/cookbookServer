<?php

require_once "RecipeStepsTest.php";

class RecipeStepsDeleteTest extends RecipeStepsTest {
    
   
    protected function prepareRequest($id){
        $request = self::$client->get('steps/delete.php?id='.$id);
        return $request;
    }
    
    
    public function testDeleteRecipeStepNotLast(){
        $response = $this->executeRequest(2, true);
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeStepsQuery, 2);
        $this->verifyStepFromOrder(1, 1, "step1");
        $this->verifyStepFromOrder(1, 2, "step3");
        $this->verifyStepFromOrder(1, 3, "step4");
    }
    
    
    public function testDeleteRecipeStepsNotFound(){
        $this->withNotFound(10, true);
    }
    
    
    public function testDeleteRecipeStepsAccessDenied(){
        $this->withAcessDenied(1);
    }
}
?>
