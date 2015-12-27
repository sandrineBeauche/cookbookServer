<?php

require_once "RecipeTest.php";


class RecipeDeleteTest extends RecipeTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", 
                                             "recipeSteps1.yml",
                                             "ingredients.yml",
                                             "users.yml", 
                                             "countries.yml", 
                                             "recipeTypes.yml"));
    }
    
    
    protected function prepareRequest($id){
        return self::$client->get('recipes/delete.php?id='.$id);
    }
    
    
    public function testDeleteRecipe(){
        $response = $this->executeRequest(4, true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeQuery, 4);
    }
    
    public function testDeleteRecipeAccessDenied(){
        $this->withAcessDenied(4);
    }
    
    public function testDeleteRecipeNotFound(){
        $this->withNotFound(10, true);
    }
    
    
    public function testDeleteRecipeWithSteps(){
        $response = $this->executeRequest(1, true);
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeQuery, 1);
        $this->verifyDeleted(self::$RecipeStepsQuery, 1);
        $this->verifyDeleted(self::$RecipeStepsQuery, 2);
    }
    
    public function testDeleteRecipeWithIngredients(){
        $response = $this->executeRequest(2, true);
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeQuery, 2);
        $this->verifyDeleted(self::$IngredientQuery, 3);
    }
}

?>
