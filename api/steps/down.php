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
                $next = $step->getNextStep();
                if(isset($next)){
                    $swap = $step->getorder();
                    $step->setorder($next->getorder());
                    $next->setorder($swap);
                
                    $step->save();
                    $next->save();
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
