<?php

session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ItemService.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $ingredient = new ingredientType();
        $ingredient->setName($_POST["name"]);

        $saved = ItemService::saveWithValidation($ingredient, 200);
        if($saved == true){
            $id = $ingredient->getId();
            
            $result = array("id" => $id);
            echo json_encode($result);
        }
    }
);
?>
