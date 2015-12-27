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
                $ingredient = ingredientQuery::create()->findPk($_GET["id"]);
            }
            
            if(isset($ingredient)){
                $ingredient->setquantity($_PUT["quantity"]);
                $ingredient->setingredientId($_PUT["ingredientId"]);
                if(array_key_exists("unitId", $_PUT)){
                    $ingredient->setunitId($_PUT["unitId"]);
                }
                else{
                    $ingredient->setunitId(null);
                }
                
                ItemService::saveWithValidation($ingredient, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );

?>
