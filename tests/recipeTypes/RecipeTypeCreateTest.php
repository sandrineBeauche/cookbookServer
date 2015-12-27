<?php

require_once "RecipeTypeTest.php";


class RecipeTypeCreateTest extends RecipeTypeTest {
    
    protected function getDataSet(){    
        return parent::generateDataset(array("recipeTypes.yml", "users.yml"));
    }
    
   
    protected function prepareRequest($args = array()){
        return self::$client->post('recipeTypes/create.php', null, $args);
    }
    
     
    public function testCreateRecipeType(){
        $args = array("name" => "nouvelle catégorie");
        $response = $this->executeRequest($args, true);
        
        $this->verifyOk($response);
        
        $result = $response->json();
        $created = recipeTypeQuery::create()->findPk($result["id"]);
        
        $this->assertEquals("nouvelle catégorie", $created->getname());
    }
    
    
    public function testCreateCountryAccessDenied(){
        $args = array("name" => "nouvelle catégorie");
        $this->withAcessDenied($args);
    }
    
    
    public function testCreateCountryExistingName(){
        $args = array("name" => "soupe");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Cette catégorie existe déja.");
        $this->verifyDatabaseNoChange();
    }
    
    
    public function testCreateCountryBadName(){
        $args = array("name" => "");
        $response = $this->executeRequest($args, true);
        
        $this->verifyErrorMessage($response, "name", "Le nom ne peut être vide.");
        $this->verifyDatabaseNoChange();
    }
   
    
}

?>
