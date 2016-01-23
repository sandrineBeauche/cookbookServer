<?php

require 'ImageService.php';


/**
 * Skeleton subclass for representing a row from the 'recipes' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.cookbook
 */
class Recipe extends BaseRecipe
{
    
    public function addRecipeSteps(RecipeSteps $step) {
        $numStep = $this->countRecipeStepss();
        $step->setorder($numStep);
        parent::addRecipeSteps($step);
    }
    
    public function refreshStepOrder($first, PropelPDO $con = null) {
        $sql = "UPDATE recipe_steps AS steps "
                ."SET steps.`order` = steps.`order` - 1 "
                ."WHERE steps.recipeId = :recipe AND steps.`order` > :firstStep";
        
        $stmt = $con->prepare($sql);
        $stmt->execute(array(':recipe' => $this->id, ':firstStep' => $first));
    }
}
