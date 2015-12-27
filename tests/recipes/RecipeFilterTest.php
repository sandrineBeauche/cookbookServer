<?php

require_once "RecipeTest.php";


class RecipeFilterTest extends RecipeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml"));
    }
    
   
    protected function prepareRequest($args){
        $request = self::$client->get(array('recipes{?data*}',
            array("data" => array(
                "filter" => $args
            ))));
        return $request;
    }
      
    public function testFilterRecipeOnCategory() {
        $expectedJson = '{"count": 2, "offset": 0, "limit": 30,
                            "data": [{"id": 1, "name": "recipe1"},
                                     {"id": 2, "name": "recipe2"}
                                    ]
                         }';
        
        $args = array("recipeTypes" => array(array(1)));
        
        $this->withJsonResult($args, $expectedJson);
    }
    
    
    public function testFilterRecipeOnOrigin() {
        $expectedJson = '{"count": 2, "offset": 0, "limit": 30,
                            "data": [{"id": 2, "name": "recipe2"},
                                     {"id": 3, "name": "recipe3"}
                                    ]
                         }';
        
        $args = array("countries" => array(array(2)));
        
        $this->withJsonResult($args, $expectedJson);
    }
    
    public function testFilterRecipeOnCategoryAndOrigin() {
        $expectedJson = '{"count": 1, "offset": 0, "limit": 30,
                            "data": [{"id": 2, "name": "recipe2"}]
                         }';
        
        $args = array("recipeTypes" => array(array(1)),
                          "countries" => array(array(2)));
        
        $this->withJsonResult($args, $expectedJson);
    }
    
}

?>
