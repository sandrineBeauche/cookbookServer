<?php
    require_once '../../../bootstrap.php';
    require '../../../services/UserService.php';
    require '../../../services/ItemService.php';

    if(array_key_exists("recipeId", $_GET)){
        $recipeId = $_GET["recipeId"];

        $recipe = RecipeQuery::create()->findPk($recipeId);
        
        if(isset($recipe)){
            $steps = RecipeStepsQuery::create()
                ->filterByRecipe($recipe)
                ->orderBy("order")
                ->select(array('id', 'description'))
                ->find();
        
            $data = $steps->getData();

            echo json_encode($data);
        }
        else{
            http_response_code(404);
        }
    }
?>
