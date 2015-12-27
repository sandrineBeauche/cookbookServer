<?php 
    require_once '../../../bootstrap.php';
        
    if(array_key_exists("recipeId", $_GET)){
        $recipeId = $_GET["recipeId"];
   
        $recipe = RecipeQuery::create()->findPk($recipeId);
        
        if(isset($recipe)){
            $ingredients = ingredientQuery::create()
                ->filterByrecipeId($recipeId)
                ->join("ingredientType")
                ->join("unit", Criteria::LEFT_JOIN)
                ->select(array('id', "quantity"))
                ->withColumn("ingredientType.name", "ingredient")
                ->withColumn("unit.name", "unit")
                ->find();
        
            $data = $ingredients->getData();
        
            echo json_encode($data);
        }
        else{
            http_response_code(404);
        }
    }
    
?>
    
