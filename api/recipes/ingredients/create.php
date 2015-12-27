<?php 

session_start();

require_once '../../../bootstrap.php';
require '../../../services/UserService.php';
require '../../../services/ItemService.php';
require '../../../utils/Exceptions.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $ingredient = new ingredient();
        $ingredient->setquantity($_POST["quantity"]);
        if(array_key_exists("unitId", $_POST)){
            $unitId = $_POST["unitId"];
            if($unitId != "-1"){
                $ingredient->setunitId($_POST["unitId"]);
            }
        }
        $ingredient->setingredientId($_POST["ingredientId"]);
        
        $recipeId = $_GET["recipeId"];
        $recipe = RecipeQuery::create()->findPk($recipeId); 
            
        if(isset($recipe)){
            $recipe->addingredient($ingredient);
        
            $saved = ItemService::saveWithValidation($ingredient, 200);
            if($saved == true){
                $id = $ingredient->getId();
            
                $result = array("id" => $id);
                echo json_encode($result);
            }
         }
         else{
             http_response_code(404);
         }
    }
);
?>
