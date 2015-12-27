<?php
    require_once '../../bootstrap.php';
    
    if(array_key_exists("offset", $_REQUEST)){
        $offset = ((int) $_REQUEST["offset"]); 
    }
    else {
        $offset = 0;
    }
    
    
    if(array_key_exists("limit", $_REQUEST)){
        $limit = (int) $_REQUEST["limit"];  
    }
    else{
        $limit = 30;
    }
    
    $query = RecipeQuery::create();
    
    if(array_key_exists("filter", $_REQUEST)){
        $filter = $_REQUEST["filter"];
        
        if(array_key_exists("recipeTypes", $filter)){
            foreach($filter["recipeTypes"] as $categoryFilter){
                $query = $query->filterBycategory($categoryFilter);
            }
        }
        
        if(array_key_exists("countries", $filter)){
            foreach($filter["countries"] as $countriesFilter){
                $query = $query->filterByorigin($countriesFilter);
            }
        }
        
        if(array_key_exists("maxCost", $filter)){
            $query = $query->filterBycost(array('max' => $filter["maxCost"]));
        }
        
        if(array_key_exists("maxDifficulty", $filter)){
            $query = $query->filterBydifficulty(array('max' => $filter["maxDifficulty"]));
        }
        
        if(array_key_exists("maxTime", $filter)){
            $query = $query->filterBytime(array('max' => $filter["maxTime"]));
        }
        
        if(array_key_exists("maxCalories", $filter)){
            $query = $query->filterBycalories(array('max' => $filter["maxCalories"]));
        }
        
        if(array_key_exists("ingredients", $filter)){
            foreach($filter["ingredients"] as $ingFilter){
                $ids = ingredientQuery::create()
                        ->filterByingredientId($ingFilter)
                        ->select(array("recipeId"))
                        ->find();
                
                $query = $query->filterByPrimaryKeys($ids);
            }
        }
        
        if(array_key_exists("tags", $filter)){
            foreach($filter["tags"] as $tagFilter){
                $ids = tagsQuery::create()
                        ->filterBytagId($tagFilter)
                        ->select(array("recipeId"))
                        ->find();
                
                $query = $query->filterByPrimaryKeys($ids);
            }
        }
    }
    
    $query = $query->select(array('id', 'name'));
    
    $count = $query->count();
    
    $recipes = $query->offset($offset)
                ->limit($limit)
                ->orderByName()
                ->find();
    $data = $recipes->getData();
    
    $result = array("count" => $count,
                    "offset" => $offset,
                    "limit" => $limit,
                    "data" => $data);
 
    echo json_encode($result);
?>
    
