<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ForeignService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $categoryId = $_GET["id"];
                $category = recipeTypeQuery::create()->findPk($categoryId);
            }
            
            $force = false;
            if(array_key_exists("force", $_GET)){
                $force = $_GET["force"];
            }
            
            if(isset($category)){
                try{
                    $databaseName = countryPeer::DATABASE_NAME;
                    $constraints = array("recipes" => "category");
                    if($force == true){
                        ForeignService::forceForeignConstraints($databaseName, $constraints, $categoryId);
                        $category->delete();
                        http_response_code(204);
                    }
                    else{
                        $result = ForeignService::verifyForeignConstraints($databaseName, $constraints, $categoryId);
                        if($result){
                            $category->delete();
                            http_response_code(204);
                        }
                        else{
                            echo json_encode(array("result" => "Cette catégorie est référencé par des recettes."));
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
