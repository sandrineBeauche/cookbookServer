<?php
    require_once '../../bootstrap.php';
    
    $recipeId = $_GET["id"];
    
    
    $recipe = RecipeQuery::create()
            ->join("country", Criteria::LEFT_JOIN)
            ->join("recipeType", Criteria::LEFT_JOIN)
            ->select(array("id", "name", "description", "photo", "cost", "difficulty", "time", "calories"))
            ->withColumn("country.id", "countryId")
            ->withColumn("country.name", "country")
            ->withColumn("country.flag", "flag")
            ->withColumn("recipeType.id", "categoryId")
            ->withColumn("recipeType.name", "category")
            ->findPk($recipeId);
    
    $tags = tagsQuery::create()
            ->join("tagNames")
            ->filterByrecipeId($recipeId)
            ->select(array("tagNames.name"))
            ->find();
            
    if(count($tags) > 0){
        $recipe["tags"] = join(', ', $tags->toArray());
    }
    
    if(isset($recipe)){
        echo json_encode($recipe);
    }
    else{
        http_response_code(404);
    }
?>
    
