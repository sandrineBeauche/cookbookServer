<?php

session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ItemService.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $unit = new unit();
        $unit->setName($_POST["name"]);

        $saved = ItemService::saveWithValidation($unit, 200);
        if($saved == true){
            $id = $unit->getId();
            
            $result = array("id" => $id);
            echo json_encode($result);
        }
    }
);
?>
