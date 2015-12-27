<?php

session_start();

require_once '../../bootstrap.php';
require '../../services/UserService.php';
require '../../services/ItemService.php';
require '../../services/TagService.php';

UserService::withRole(UserService::$CONTRIBUTOR, 
    function() {
        $recipe = new Recipe();
        if(array_key_exists("name", $_POST)){
            $recipe->setName($_POST["name"]);
        }
        
        if(array_key_exists("description", $_POST)){
            $recipe->setDescription($_POST["description"]);
        }
        
        if(array_key_exists("photo", $_POST)){
            $recipe->setphoto($_POST['photo']);
        }
        
        if(array_key_exists("cost", $_POST)){
            $recipe->setcost($_POST['cost']);
        }
        
        if(array_key_exists("difficulty", $_POST)){
            $recipe->setdifficulty($_POST['difficulty']);
        }
        
        if(array_key_exists("time", $_POST)){
            $recipe->settime($_POST['time']);
        }
        
        if(array_key_exists("calories", $_POST)){
            $recipe->setcalories($_POST['calories']);
        }
        
        if(array_key_exists("countryId", $_POST)){
            $origin = $_POST["countryId"];
            if($origin != "-1"){
                $recipe->setorigin($origin);
            }
        }
        
        if(array_key_exists("categoryId", $_POST)){
            $category = $_POST["categoryId"];
            if($category != "-1"){
                $recipe->setcategory($category);
            }
        }

        if(array_key_exists("tags", $_POST)){
            $tags = TagService::processTags($_POST["tags"]);
            foreach($tags as $current){
                $newTag = new tags();
                $newTag->settagNames($current);
                $recipe->addtags($newTag);
            }
        }
        
        $saved = ItemService::saveWithValidation($recipe, 200);
        if($saved == true){
            $id = $recipe->getId();
            
            $result = array("id" => $id);
            echo json_encode($result);
        }
    }
);
?>
