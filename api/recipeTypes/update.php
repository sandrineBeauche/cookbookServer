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
                $categoryId = $_GET["id"];
                $category = countryQuery::create()->findPk($categoryId);
            }
                
            if(isset($category)){
                $category->setName($_PUT["name"]);
                ItemService::saveWithValidation($category, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
