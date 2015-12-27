<?php

require_once "CountryTest.php";


class CountryDeleteTest extends CountryTest {

    protected function getDataSet(){    
        return parent::generateDataset(array("recipes.yml", 
                                             "users.yml", 
                                             "countries.yml"));
    }
    
    
    protected function prepareRequest($args){
        $url = 'countries/delete.php?id='.$args["id"];
        if(array_key_exists("force", $args)){
            $url = $url."&force=".$args["force"];
        }
        return self::$client->get($url);
    }
    
    
    public function testDeleteCountry(){
        $response = $this->executeRequest(array("id" => 3), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$CountryQuery, 3);
    }
    
    
    public function testDeleteCountryWithForeign(){
        $response = $this->executeRequest(array("id" => 2), true);
        
        $this->verifyOk($response, 200);
        $this->verifyDatabaseNoChange();
        $result = $response->json();
        $this->assertEquals("Ce pays est référencé par des recettes.", $result["result"]);
    }
    
    
    public function testDeleteCountryWithForeignForce(){
        $response = $this->executeRequest(array("id" => 2, "force" => "true"), true);
        
        $this->verifyOk($response, 204);
        $this->verifyDeleted(self::$CountryQuery, 2);
        $recipe2 = RecipeQuery::create()->findPk(2);
        $recipe3 = RecipeQuery::create()->findPk(3);
        $this->assertEquals(null, $recipe2->getorigin());
        $this->assertEquals(null, $recipe3->getorigin());
    }
    
    
    public function testDeleteCountryAccessDenied(){
        $this->withAcessDenied(array("id" => 1));
    }
    
    public function testDeleteCountryNotFound(){
        $this->withNotFound(array("id" => 10), true);
    }
   
}

?>
