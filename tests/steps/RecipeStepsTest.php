<?php

require_once __DIR__."/../CookbookTest.php";

abstract class RecipeStepsTest extends CookbookTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "recipeSteps2.yml", "users.yml"));
    }
   
    
    protected function verifyStepFromOrder($recipeId, $order, $description){
        $step = RecipeStepsQuery::create()
                    ->filterByrecipeId($recipeId)
                    ->filterByorder($order)
                    ->findOne();
        
        $this->assertNotNull($step);
        $this->assertEquals($description, $step->getdescription());
    }
    
    protected function verifyStep($stepId, $description){
        $step = RecipeStepsQuery::create()->findPk($stepId);
        
        $this->assertNotNull($step);
        $this->assertEquals($description, $step->getdescription());
    }
    
}
?>
