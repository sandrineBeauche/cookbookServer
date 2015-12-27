<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ForeignService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $countryId = $_GET["id"];
                $country = countryQuery::create()->findPk($countryId);
            }
            
            $force = false;
            if(array_key_exists("force", $_GET)){
                $force = $_GET["force"];
            }
            
            if(isset($country)){
                try{
                    $databaseName = countryPeer::DATABASE_NAME;
                    $constraints = array("recipes" => "origin");
                    if($force == true){
                        ForeignService::forceForeignConstraints($databaseName, $constraints, $countryId);
                        $country->delete();
                        http_response_code(204);
                    }
                    else{
                        $result = ForeignService::verifyForeignConstraints($databaseName, $constraints, $countryId);
                        if($result){
                            $country->delete();
                            http_response_code(204);
                        }
                        else{
                            echo json_encode(array("result" => "Ce pays est référencé par des recettes."));
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
