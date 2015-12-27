<?php

session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ItemService.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $country = new country();
        $country->setName($_POST["name"]);
        $country->setflag($_POST["flag"]);

        $saved = ItemService::saveWithValidation($country, 200);
        if($saved == true){
            $id = $country->getId();
            
            $result = array("id" => $id);
            echo json_encode($result);
        }
    }
);
?>
