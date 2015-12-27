<?php

require_once "RecipeTypeTest.php";


class RecipeTypeDeleteTest extends RecipeTypeTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", 
                                             "users.yml", 
                                             "recipeTypes.yml"));
    }
    
    
    protected function prepareRequest($args){
        $url = 'recipeTypes/delete.php?id='.$args["id"];
        if(array_key_exists("force", $args)){
            $url = $url."&force=".$args["force"];
        }
        return self::$client->get($url);
    }
    
    
    public function testDeleteRecipeType(){
        $response = $this->executeRequest(array("id" => 3), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeTypeQuery, 3);
    }
    
    
    public function testDeleteRecipeTypeWithForeign(){
        $response = $this->executeRequest(array("id" => 1), true);
        
        $this->verifyOk($response, 200);
        $this->verifyDatabaseNoChange();
        $result = $response->json();
        $this->assertEquals("Cette catégorie est référencé par des recettes.", $result["result"]);
    }
    
    
    public function testDeleteRecipeTypeWithForeignForce(){
        $response = $this->executeRequest(array("id" => 1, "force" => "true"), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$RecipeTypeQuery, 1);
        $recipe1 = RecipeQuery::create()->findPk(1);
        $recipe2 = RecipeQuery::create()->findPk(2);
        $this->assertEquals(null, $recipe1->getcategory());
        $this->assertEquals(null, $recipe2->getcategory());
    }
    
    
    public function testDeleteRecipeTypeAccessDenied(){
        $this->withAcessDenied(array("id" => 1));
    }
    
    public function testDeleteRecipeTypeNotFound(){
        $this->withNotFound(array("id" => 10), true);
    }
   
}

?>
