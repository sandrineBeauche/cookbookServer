<?php

class CIRPeerUtils {
    
    public static function addCIRValidation(TableMap $map, ColumnMap $column, $message = null){
        $columnName = $column->getColumnName();
        $value = $column->getRelatedTableName();
        if(!isset($message)){
            $message = $value." non trouvé";
        }
        $map->addValidator($columnName, "class", "utils.CIRValidator", $value, $message);
    }
    
    public static function addCIRValidations(TableMap $map, array $columns = null)
    {
        $foreigns = $map->getForeignKeys();
        
        foreach ($foreigns as $currentForeign) {
            $columnName = $currentForeign->getColumnName();
            if(!isset($columns) || array_key_exists($columnName, $columns)){
                if(isset($columns)){
                    $message = $columns[$columnName];
                    CIRPeerUtils::addCIRValidation($map, $currentForeign, $message);
                }
                else{
                    CIRPeerUtils::addCIRValidation($map, $currentForeign);
                }
            }
        }
    }
}
?>
