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
                $ingredientId = $_GET["id"];
                $ingredient = ingredientTypeQuery::create()->findPk($ingredientId);
            }
                
            if(isset($ingredient)){
                $ingredient->setName($_PUT["name"]);
                ItemService::saveWithValidation($ingredient, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
