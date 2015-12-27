<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ForeignService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $unitId = $_GET["id"];
                $unit = unitQuery::create()->findPk($unitId);
            }
            
            $force = false;
            if(array_key_exists("force", $_GET)){
                $force = $_GET["force"];
            }
            
            if(isset($unit)){
                try{
                    $databaseName = unitPeer::DATABASE_NAME;
                    $constraints = array("ingredient" => "unitId");
                    if($force == true){
                        ForeignService::forceForeignConstraints($databaseName, $constraints, $unitId, true);
                        $unit->delete();
                        http_response_code(204);
                    }
                    else{
                        $result = ForeignService::verifyForeignConstraints($databaseName, $constraints, $unitId);
                        if($result){
                            $unit->delete();
                            http_response_code(204);
                        }
                        else{
                            echo json_encode(array("result" => "Cette unité est référencée dans des ingredients de recette."));
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
