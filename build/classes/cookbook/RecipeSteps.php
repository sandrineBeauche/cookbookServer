<?php

//require 'RecipeStepsQuery.php';

/**
 * Skeleton subclass for representing a row from the 'recipeSteps' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.cookbook
 */
class RecipeSteps extends BaseRecipeSteps
{
    public function postDelete(PropelPDO $con = null) {
        parent::postDelete($con);
        $recipe = $this->getRecipe();
        $numStep = $this->order;
        $recipe->refreshStepOrder($numStep, $con);
    }
    
    
    public function getPreviousStep() {
        if($this->order > 1){
            $result = RecipeStepsQuery::create()
                        ->filterByrecipeId($this->recipeid)
                        ->filterByorder($this->order - 1)
                        ->findOne();
            return $result;
        }
        else{
            return null;
        }
    }
    
    
    public function getNextStep() {
        $recipe = RecipeQuery::create()->findPk($this->recipeid);
        $max = $recipe->countRecipeStepss();
        if($this->order < $max){
            $result = RecipeStepsQuery::create()
                        ->filterByrecipeId($this->recipeid)
                        ->filterByorder($this->order + 1)
                        ->findOne();
            return $result;
        }
        else{
            return null;
        }
    }
}
