<?php

require_once __DIR__."/../CookbookTest.php";

abstract class RecipeTest extends CookbookTest {
    
    protected $defaultArgs = array("name" => "tarte à la crème",
                                    "description" => "c'est trop bon!");
}
?>
