<?php

require_once "RecipeTest.php";


class RecipeCreateTest extends RecipeTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "countries.yml", "recipeTypes.yml", "users.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        $finalArgs = array_merge($this->defaultArgs, $args);
        return self::$client->post('recipes/create.php', null, $finalArgs);
    }
    
     
    public function testCreateRecipe1(){
        $response = $this->executeRequest(array(), true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = RecipeQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("tarte à la crème", $created->getname());
        $this->assertEquals("c'est trop bon!", $created->getdescription());
        $this->assertNull($created->getphoto());
        $this->assertNull($created->getcategory());
        $this->assertNull($created->getorigin());
        $this->assertNull($created->getcost());
        $this->assertNull($created->getdifficulty());
        $this->assertNull($created->gettime());
        $this->assertNull($created->getcalories());
    }
    
    
    public function testCreateRecipe2(){
        $args = array(
            'photo' => 'http://p2.storage.canalblog.com/25/08/410020/76813294_o.jpg',
            'categoryId' => 1,
            'countryId' => 1,
            'cost' => 2,
            'difficulty' => 2,
            'time' => 2,
            'calories' => 2
        );
        
        $response = $this->executeRequest($args, true);
        
        $this->assertEquals(200, $response->getStatusCode());
        
        $result = $response->json();
        $created = RecipeQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("tarte à la crème", $created->getname());
        $this->assertEquals("c'est trop bon!", $created->getdescription());
        $this->assertEquals("http://p2.storage.canalblog.com/25/08/410020/76813294_o.jpg", $created->getphoto());
        $this->assertEquals(1, $created->getcategory());
        $this->assertEquals(1, $created->getorigin());
        $this->assertEquals(2, $created->getcost());
        $this->assertEquals(2, $created->getdifficulty());
        $this->assertEquals(2, $created->gettime());
        $this->assertEquals(2, $created->getcalories());
    }
    
    
    public function testCreateRecipeAccessDenied(){
        $this->withAcessDenied(array());
    }
    
    
    public function testCreateRecipeExistingName(){
        $response = $this->executeRequest(array("name" => "recipe2"), true);
        
        $this->verifyErrorMessage($response, "name", "Cette recette existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeBadName(){
        $response = $this->executeRequest(array("name" => ""), true);
        
        $this->verifyErrorMessage($response, "name", "Entrez un nom de recette valide.");
        $this->verifyDatabaseNoChange();
    }
    
    public function testCreateRecipeCountryNotFound(){
        $response = $this->executeRequest(array('countryId' => 4), true);
        
        $this->verifyErrorMessage($response, "origin", "Pays non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeCategoryNotFound(){
        $response = $this->executeRequest(array('categoryId' => 4), true);
        
        $this->verifyErrorMessage($response, "category", "Type de recette non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeCostOutOfBound1(){
        $response = $this->executeRequest(array('cost' => 0), true);
        
        $this->verifyErrorMessage($response, "cost", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    public function testCreateRecipeCostOutOfBound2(){
        $response = $this->executeRequest(array('cost' => 6), true);
        
        $this->verifyErrorMessage($response, "cost", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeDifficultyOutOfBound1(){
        $response = $this->executeRequest(array('difficulty' => 0), true);
        
        $this->verifyErrorMessage($response, "difficulty", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    public function testCreateRecipeDifficultyOutOfBound2(){
        $response = $this->executeRequest(array('difficulty' => 6), true);
        
        $this->verifyErrorMessage($response, "difficulty", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeTimeOutOfBound1(){
        $response = $this->executeRequest(array('time' => 0), true);
        
        $this->verifyErrorMessage($response, "time", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    public function testCreateRecipeTimeOutOfBound2(){
        $response = $this->executeRequest(array('time' => 6), true);
        
        $this->verifyErrorMessage($response, "time", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateRecipeCaloriesOutOfBound1(){
        $response = $this->executeRequest(array('calories' => 0), true);
        
        $this->verifyErrorMessage($response, "calories", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
    public function testCreateRecipeCaloriesOutOfBound2(){
        $response = $this->executeRequest(array('calories' => 6), true);
        
        $this->verifyErrorMessage($response, "calories", "La valeur doit être comprise entre 1 et 5");
        $this->verifyDatabaseNoChange();
    }
    
}

?>
