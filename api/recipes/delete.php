<?php
session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
    
UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            if(array_key_exists("id", $_GET)){
                $recipeId = $_GET["id"];
                $recipe = RecipeQuery::create()->findPk($recipeId);
            }
            
            if(isset($recipe)){
                try{
                    tagsQuery::create()->filterByRecipe($recipe)->delete();
                    $recipe->delete();
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
