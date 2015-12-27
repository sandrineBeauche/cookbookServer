<?php

class ForeignService
{
    
    public static function verifyForeignConstraints($databaseName, $constraints, $id){
        $con = Propel::getConnection($databaseName);
        foreach ($constraints as $key => $value) {
            $sql = "SELECT id FROM ".$key." WHERE ".$value." = :id";
            $stmt = $con->prepare($sql);
            $stmt->execute(array(':id' => $id));
            $result = $stmt->fetchAll();
            if(count($result) > 0){
                return false;
            }
        }
        return true;
    }
    
    
    public static function forceForeignConstraints($databaseName, $constraints, $id, $deleteLine = false){
        $con = Propel::getConnection($databaseName);
        foreach ($constraints as $key => $value) {
            if($deleteLine == true){
                $sql = "DELETE FROM ".$key." WHERE ".$value." = :id";
            }
            else{
                $sql = "UPDATE ".$key." SET ".$value." = NULL WHERE ".$value." = :id";
            }
            $stmt = $con->prepare($sql);
            $stmt->execute(array(':id' => $id));
        }
    }
    
   
}
?>
