<?php

require_once "UnitTest.php";


class UnitFindAllTest extends UnitTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("units.yml"));
    }
    
    protected function prepareRequest($args = null){
        $request = self::$client->get('units');
        return $request;
    }
    
    public function testGetUnits() {
        $expectedJson = '[{"id":"3", "name":"cas"},
                          {"id":"2", "name":"cl"},
                          {"id":"1", "name":"gr"}]';
        
        $this->withJsonResult(null, $expectedJson);
    }
}

?>
