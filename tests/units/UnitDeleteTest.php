<?php

require_once "UnitTest.php";


class UnitDeleteTest extends UnitTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("ingredients.yml", 
                                             "users.yml", 
                                             "units.yml"));
    }
    
    
    protected function prepareRequest($args){
        $url = 'units/delete.php?id='.$args["id"];
        if(array_key_exists("force", $args)){
            $url = $url."&force=".$args["force"];
        }
        return self::$client->get($url);
    }
    
    
    public function testDeleteUnit(){
        $response = $this->executeRequest(array("id" => 3), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$UnitQuery, 3);
    }
    
    
    public function testDeleteUnitWithForeign(){
        $response = $this->executeRequest(array("id" => 2), true);
        
        $this->verifyOk($response, 200);
        $this->verifyDatabaseNoChange();
        $result = $response->json();
        $this->assertEquals("Cette unité est référencée dans des ingredients de recette.", $result["result"]);
    }
    
    
    public function testDeleteUnitWithForeignForce(){
        $response = $this->executeRequest(array("id" => 2, "force" => "true"), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$UnitQuery, 2);
        $this->assertNull(ingredientQuery::create()->findPk(2));
    }
    
    
    public function testDeleteUnitAccessDenied(){
        $this->withAcessDenied(array("id" => 1));
    }
    
    public function testDeleteUnitNotFound(){
        $this->withNotFound(array("id" => 10), true);
    }
   
}

?>
