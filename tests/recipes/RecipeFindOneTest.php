<?php

require_once "RecipeTest.php";


class RecipeFindOneTest extends RecipeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", "countries.yml", "recipeTypes.yml"));
    }
    
    protected function prepareRequest($id) {
        return self::$client->get('recipes/'.$id);
    }

    public function testFindRecipe(){
        $expectedJson = '{"id": 1,
                          "name": "recipe1",
                          "description": "recipe1 description",
                          "photo": null,
                          "cost": 3,
                          "difficulty": 3,
                          "time": 3,
                          "calories": 3,
                          "countryId": 1,
                          "country": "France",
                          "flag": "http://www.drapeauxdespays.fr/data/flags/mini/fr.png",
                          "categoryId": 1,
                          "category": "soupe"}';
        
       
        $this->withJsonResult(1, $expectedJson);
    }

    
    
}

?>
