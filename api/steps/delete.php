<?php
    session_start();

    require_once '../../bootstrap.php';
    require '../../services/UserService.php';

    UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $stepId = $_GET["id"];
                $step = RecipeStepsQuery::create()->findPk($stepId);
            }
            
            if(isset($step)){
                try{
                    $step->delete();
                    http_response_code(204);
                }
                catch (PropelException $ex){
                    http_response_code(500);
                }
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
