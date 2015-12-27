<?php
    session_start();

    require_once '../../bootstrap.php';
    require '../../services/UserService.php';
    require '../../services/ItemService.php';
    require '../../services/RequestService.php';
    require '../../services/TagService.php';
    
    UserService::withRole(UserService::$CONTRIBUTOR, 
        function() {
            $_PUT = RequestService::processPutParams();
    
            if(array_key_exists("id", $_GET)){
                $recipeId = $_GET["id"];
                $recipe = RecipeQuery::create()->findPk($recipeId);
            }
                
            if(isset($recipe)){
                $recipe->setName($_PUT["name"]);
                $recipe->setDescription($_PUT["description"]);
                
                if(array_key_exists("photo", $_PUT)){
                    $recipe->setphoto($_PUT['photo']);
                }
                
                if(array_key_exists("cost", $_PUT)){
                    $recipe->setcost($_PUT['cost']);
                }
                
                if(array_key_exists("difficulty", $_PUT)){
                    $recipe->setdifficulty($_PUT['difficulty']);
                }
                
                if(array_key_exists("time", $_PUT)){
                    $recipe->settime($_PUT['time']);
                }
                
                if(array_key_exists("calories", $_PUT)){
                    $recipe->setcalories($_PUT['calories']);
                }
                
                if(array_key_exists("countryId", $_PUT) && $_PUT["countryId"] != "-1"){
                    $recipe->setorigin($_PUT["countryId"]);
                }
                else{
                    $recipe->setcountry();
                }
        
                if(array_key_exists("categoryId", $_PUT) && $_PUT["categoryId"] != "-1"){
                    $recipe->setcategory($_PUT["categoryId"]);
                }
                else{
                    $recipe->setrecipeType();
                }
                
                if(array_key_exists("tags", $_PUT)){
                    $tags = TagService::processTags($_PUT["tags"]);
                    foreach($tags as $current){
                        $tagsId[] = $current->getid();
                    }
                    
                    tagsQuery::create()->filterByRecipe($recipe)
                        ->where("tags.tagId NOT IN ?", $tagsId)
                        ->delete();
        
                    $existingTags = tagsQuery::create()->filterByRecipe($recipe)
                        ->select(array("tagId"))
                        ->find()->toArray();
        
                    foreach($tagsId as $index => $current){
                        if(!in_array($current, $existingTags)){
                            $newTag = new tags();
                            $newTag->settagNames($tags[$index]);
                            $recipe->addtags($newTag);
                        }
                    }
                }
    
                ItemService::saveWithValidation($recipe, 204);
            }
            else{
                http_response_code(404);
            }
        }
    );
?>
