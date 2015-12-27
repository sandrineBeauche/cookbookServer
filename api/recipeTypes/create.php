<?php

session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ItemService.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $category = new recipeType();
        $category->setName($_POST["name"]);

        $saved = ItemService::saveWithValidation($category, 200);
        if($saved == true){
            $id = $category->getId();
            
            $result = array("id" => $id);
            echo json_encode($result);
        }
    }
);
?>
