<?php

/**
 * A simple validator for foreign key fields.
 *
 * @package propel.validator
 */
class CIRValidator implements BasicValidator
{
    public function isValid(ValidatorMap $map, $str)
    {
        $value = $map->getValue();
        
        $con = Propel::getConnection(RecipePeer::DATABASE_NAME);
        $sql = "SELECT id FROM ".$value." WHERE id = :id";
        $stmt = $con->prepare($sql);
        $stmt->execute(array(':id' => $str));
      
        $result = $stmt->fetchAll();
        return (count($result) > 0);
    }
}
?>
