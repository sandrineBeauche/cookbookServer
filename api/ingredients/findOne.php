<?php
    require_once '../../bootstrap.php';
    
    $ingredientId = $_GET["id"];
    
    
    $ingredient = ingredientQuery::create()->findPk($ingredientId);
    if(isset($ingredient)){
        echo $ingredient->toJSON(true);
    }
    else{
        http_response_code(404);
    }
?>
    
