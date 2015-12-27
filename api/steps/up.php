<?php

    session_start();

    require_once '../../bootstrap.php';
    require '../../services/UserService.php';
    
    UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $recipeStepId = $_GET["id"];
                $step = RecipeStepsQuery::create()->findPk($recipeStepId);
            }
            
            if(isset($step)){
                $previous = $step->getPreviousStep();
                if(isset($previous)){
                    $swap = $previous->getorder();
                    $previous->setorder($step->getorder());
                    $step->setorder($swap);
                    
                    $previous->save();
                    $step->save();
                }
                http_response_code(204);
                echo "true";
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
