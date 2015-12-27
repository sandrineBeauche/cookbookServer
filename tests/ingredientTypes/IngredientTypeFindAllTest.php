<?php

require_once "IngredientTypeTest.php";


class IngredientTypeFindAllTest extends IngredientTypeTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("ingredientTypes.yml"));
    }
    
    protected function prepareRequest($args = null){
        $request = self::$client->get('ingredientTypes');
        return $request;
    }
    
    public function testGetUnits() {
        $expectedJson = '[{"id":"4", "name":"farine"},
                          {"id":"2", "name":"lait"},
                          {"id":"1", "name":"oeufs"},
                          {"id":"3", "name":"sucre"}]';
        
        $this->withJsonResult(null, $expectedJson);
    }
}

?>
