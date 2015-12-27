<?php

require_once "RecipeTest.php";


class RecipeFindAllTest extends RecipeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml"));
    }
    
    protected function prepareRequest($args = null){
        if($args == null){
            $request = self::$client->get('recipes');
        }
        else{
            $request = self::$client->get(array('recipes{?data*}',
                array("data" => $args)));
        }
        
        return $request;
    }
    
    public function testGetRecipes1() {
        $expectedJson = '{"count": 6, "offset": 0, "limit": 30,
                            "data": [{"id": 1, "name": "recipe1"},
                                     {"id": 2, "name": "recipe2"},
                                     {"id": 3, "name": "recipe3"},
                                     {"id": 4, "name": "recipe4"},
                                     {"id": 5, "name": "recipe5"},
                                     {"id": 6, "name": "recipe6"}
                                    ]
                         }';
        
        $this->withJsonResult(null, $expectedJson);
    }
    
    
    public function testGetRecipes2() {
        $expectedJson = '{"count": 6, "offset": 0, "limit": 2,
                            "data": [{"id": 1, "name": "recipe1"},
                                     {"id": 2, "name": "recipe2"}
                                    ]
                         }';
        
        $args = array("offset" => 0, "limit" => 2);
        
        $this->withJsonResult($args, $expectedJson);
    }
    
    
    public function testGetRecipes3() {
        $expectedJson = '{"count": 6, "offset": 1, "limit": 2,
                            "data": [{"id": 2, "name": "recipe2"},
                                     {"id": 3, "name": "recipe3"}
                                    ]
                         }';
        
        $args = array("offset" => 1, "limit" => 2);
        
        $this->withJsonResult($args, $expectedJson);
    }
}

?>
