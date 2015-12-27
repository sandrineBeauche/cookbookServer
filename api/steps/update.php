<?php

    session_start();

    require_once '../../bootstrap.php';
    require '../../services/UserService.php';
    require '../../services/ItemService.php';
    require '../../services/RequestService.php';
    
    UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            $_PUT = RequestService::processPutParams();
            
            if(array_key_exists("id", $_GET)){
                $recipeStepId = $_GET["id"];
                $step = RecipeStepsQuery::create()->findPk($recipeStepId);
            }
            
            if(isset($step)){
                $step->setdescription($_PUT["description"]);
                ItemService::saveWithValidation($step, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );

?>
