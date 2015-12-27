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
                $countryId = $_GET["id"];
                $country = countryQuery::create()->findPk($countryId);
            }
                
            if(isset($country)){
                $country->setName($_PUT["name"]);
                $country->setflag($_PUT["flag"]);
                ItemService::saveWithValidation($country, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
