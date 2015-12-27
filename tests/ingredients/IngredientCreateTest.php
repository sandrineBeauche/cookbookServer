<?php

require_once "IngredientTest.php";


class IngredientCreateTest extends IngredientTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", 
                                             "users.yml", 
                                             "ingredientTypes.yml",
                                             "units.yml",
                                             "ingredients.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        return self::$client->post('recipes/ingredients/create.php?recipeId='.$args["recipeId"], null, $args);
    }
    
     
    public function testCreateIngredient(){
        $args = array("quantity" => 10, "unitId" => 1, "ingredientId" => 1, "recipeId" => 1);
        $response = $this->executeRequest($args, true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = ingredientQuery::create()->findPk($result["id"]);
        
        $this->assertEquals(10, $created->getquantity());
        $this->assertEquals(1, $created->getunitId());
        $this->assertEquals(1, $created->getingredientId());
        $this->assertEquals(1, $created->getrecipeId());
    }
    
    
    public function testCreateIngredientAccessDenied(){
        $args = array("quantity" => 10, "unitId" => 1, "ingredientId" => 1, "recipeId" => 1);
        $this->withAcessDenied($args);
    }
    
    
    public function testCreateIngredientBadQuantity(){
        $args = array("quantity" => -5, "unitId" => 1, "ingredientId" => 1, "recipeId" => 1);
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "quantity", "Une quantité ne peut être négative");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateIngredientUnitNotFound(){
        $args = array("quantity" => 10, "unitId" => 10, "ingredientId" => 1, "recipeId" => 1);
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "unitId", "Unité non trouvée");
        $this->verifyDatabaseNoChange();
    }
   
    
    public function testCreateIngredientIngredientNotFound(){
        $args = array("quantity" => 10, "unitId" => 1, "ingredientId" => 10, "recipeId" => 1);
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "ingredientId", "Ingredient non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateIngredientRecipeNotFound(){
        $args = array("quantity" => 10, "unitId" => 1, "ingredientId" => 1, "recipeId" => 10);
        $this->withNotFound($args);
    }
    
}

?>
