<?php

require_once "RecipeTest.php";


class RecipeUpdateTest extends RecipeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "countries.yml", "recipeTypes.yml", "users.yml"));
    }
    
    
    protected function prepareRequest($args = array()){
        $finalArgs = array_merge($this->defaultArgs, $args["values"]);
        return self::$client->post('recipes/update.php?id='.$args["id"], null, $finalArgs);
    }
    
    
    public function testUpdateRecipe(){
        $response = $this->executeRequest(array("id" => 1, "values" => array()), true);
        
        $this->verifyOk($response, 204);
        
        $recipe = RecipeQuery::create()->findPk(1);
        $this->assertEquals("tarte à la crème", $recipe->getName());
        $this->assertEquals("c'est trop bon!", $recipe->getDescription());
    }
    
    
    public function testUpdateRecipeAccessDenied(){
        $this->withAcessDenied(array("id" => 1, "values" => array()));
    }
    
    public function testUpdateRecipeNotFound(){
        $this->withNotFound(array("id" => 10, "values" => array()), true);
    }
    
    
    public function testUpdateRecipeBadName(){
        $args = array("id" => 1, "values" => array("name" => ""));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "name", "Entrez un nom de recette valide.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateRecipeExistingName(){
        $args = array("id" => 1, "values" => array("name" => "recipe2"));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "name", "Cette recette existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeCountryNotFound(){
        $args = array("id" => 1, "values" => array('countryId' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "origin", "Pays non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeCategoryNotFound(){
        $args = array("id" => 1, "values" => array('categoryId' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "category", "Type de recette non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateRecipeCostTooLow(){
        $args = array("id" => 1, "values" => array('cost' => 0));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "cost", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeCostTooHigh(){
        $args = array("id" => 1, "values" => array('cost' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "cost", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeDifficultyTooLow(){
        $args = array("id" => 1, "values" => array('difficulty' => 0));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "difficulty", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeDifficultyTooHigh(){
        $args = array("id" => 1, "values" => array('difficulty' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "difficulty", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeTimeTooLow(){
        $args = array("id" => 1, "values" => array('time' => 0));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "time", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeTimeTooHigh(){
        $args = array("id" => 1, "values" => array('time' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "time", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeCaloriesTooLow(){
        $args = array("id" => 1, "values" => array('calories' => 0));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "calories", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateRecipeCaloriesTooHigh(){
        $args = array("id" => 1, "values" => array('calories' => 6));
        $response = $this->executeRequest($args, true);
        $this->verifyErrorMessage($response, "calories", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
}

?>
