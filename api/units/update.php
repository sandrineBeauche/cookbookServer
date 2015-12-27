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
                $unitId = $_GET["id"];
                $unit = unitQuery::create()->findPk($unitId);
            }
                
            if(isset($unit)){
                $unit->setName($_PUT["name"]);
                ItemService::saveWithValidation($unit, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
