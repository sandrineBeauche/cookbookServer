<?php

require_once "CountryTest.php";


class CountryFindAllTest extends CountryTest {
   

    protected function getDataSet(){    
        return parent::generateDataset(array("countries.yml"));
    }
    
    protected function prepareRequest($args = null){
        $request = self::$client->get('countries');
        return $request;
    }
    
    public function testGetCountry() {
        $expectedJson = '[{"id":"3", "name":"Chine"},
                          {"id":"1", "name":"France"},
                          {"id":"2", "name":"Tunisie"}]';
        
        $this->withJsonResult(null, $expectedJson);
    }
}

?>
