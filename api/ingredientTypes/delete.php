<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ForeignService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $ingredientId = $_GET["id"];
                $ingredient = ingredientTypeQuery::create()->findPk($ingredientId);
            }
            
            $force = false;
            if(array_key_exists("force", $_GET)){
                $force = $_GET["force"];
            }
            
            if(isset($ingredient)){
                try{
                    $databaseName = unitPeer::DATABASE_NAME;
                    $constraints = array("ingredient" => "ingredientId");
                    if($force == true){
                        ForeignService::forceForeignConstraints($databaseName, $constraints, $ingredientId, true);
                        $ingredient->delete();
                        http_response_code(204);
                    }
                    else{
                        $result = ForeignService::verifyForeignConstraints($databaseName, $constraints, $ingredientId);
                        if($result){
                            $ingredient->delete();
                            http_response_code(204);
                        }
                        else{
                            echo json_encode(array("result" => "Cet ingredient est référencée dans les ingredients de recette."));
                        }
                    }
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
