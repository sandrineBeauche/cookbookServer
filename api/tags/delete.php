<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ForeignService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $tagId = $_GET["id"];
                $tag = tagNamesQuery::create()->findPk($tagId);
            }
            
            if(isset($tag)){
                try{
                    $tag->delete();
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
