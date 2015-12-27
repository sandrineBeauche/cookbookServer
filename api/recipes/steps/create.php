<?php 

session_start();

require_once '../../../bootstrap.php';
require '../../../services/UserService.php';
require '../../../services/ItemService.php';


UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $step = new RecipeSteps();
        $step->setdescription($_POST["description"]);

        $recipeId = $_GET["recipeId"];
        $recipe = RecipeQuery::create()->findPk($recipeId); 
        if(isset($recipe)){
            $recipe->addRecipeSteps($step);
        
            $saved = ItemService::saveWithValidation($recipe, 200);
            if($saved == true){
                $id = $step->getId();
            
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
