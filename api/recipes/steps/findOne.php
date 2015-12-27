<?php
    require_once '../../../bootstrap.php';
    
    $recipeId = $_GET["recipeId"];
    $stepOrder = $_GET["id"];
    
    $step = RecipeStepsQuery::create()
                ->filterByrecipeId($recipeId)
                ->filterByorder($stepOrder)
                ->select(array('id', 'description', 'order'))
                ->find()
                ->getFirst();
    
    if(isset($step)){
        echo json_encode($step);
    }
    else{
        http_response_code(404);
    }
?>