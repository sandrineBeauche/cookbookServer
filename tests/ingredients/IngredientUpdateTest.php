<?php

require_once "IngredientTest.php";


class IngredientUpdateTest extends IngredientTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "users.yml", "ingredients.yml", "units.yml", "ingredientTypes.yml"));
    }
    
    
    protected function prepareRequest($args = array()){
        return self::$client->post('ingredients/update.php?id='.$args["id"], null, $args["values"]);
    }
    
    
    public function testUpdateIngredient(){
        $args = array("quantity" => 70, "unitId" => 2, "ingredientId" => 2, "recipeId" => 1);
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyOk($response, 204);
        
        $ingredient = ingredientQuery::create()->findPk(1);
        $this->assertEquals(70, $ingredient->getquantity());
        $this->assertEquals(2, $ingredient->getunitId());
        $this->assertEquals(2, $ingredient->getingredientId());
        $this->assertEquals(1, $ingredient->getrecipeId());
    }
    
    public function testUpdateIngredientBadQuantity(){
        $args = array("quantity" => -5, "unitId" => 2, "ingredientId" => 2, "recipeId" => 1);
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "quantity", "Une quantité ne peut être négative");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateIngredientUnitNotFound(){
        $args = array("quantity" => 70, "unitId" => 10, "ingredientId" => 2, "recipeId" => 1);
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "unitId", "Unité non trouvée");
        $this->verifyDatabaseNoChange();
    }
    
    public function testUpdateIngredientIngredientNotFound(){
        $args = array("quantity" => 70, "unitId" => 2, "ingredientId" => 10, "recipeId" => 1);
        $response = $this->executeRequest(array("id" => 1, "values" => $args), true);
        
        $this->verifyErrorMessage($response, "ingredientId", "Ingredient non trouvé");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testUpdateIngredientAccessDenied(){
        $args = array("quantity" => 70, "unitId" => 2, "ingredientId" => 2, "recipeId" => 1);
        $this->withAcessDenied(array("id" => 1, "values" => $args));
    }
    
    public function testUpdateIngredientNotFound(){
        $args = array("quantity" => 70, "unitId" => 2, "ingredientId" => 2, "recipeId" => 1);
        $this->withNotFound(array("id" => 10, "values" => $args), true);
    }
    
}

?>
