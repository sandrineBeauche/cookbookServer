<?php

/**
 * Description of ItemService
 *
 * @author Asus
 */
class ItemService {

    public static function saveWithValidation($item, $codeSuccess){
        if ($item->validate()) {
            $item->save();
            http_response_code($codeSuccess);
            return true;
        } 
        else {
            http_response_code(200);

            $messages = array();
            foreach ($item->getValidationFailures() as $failure) {
                $longColName = explode('.', $failure->getColumn());
                $colName = $longColName[count($longColName) - 1];
                $messages[$colName] = $failure->getMessage();
            }
            
            $result = array("errors" => $messages);
            echo json_encode($result);
            return false;
        }
    }
    
    
    public static function mergeResults($res1, $res2){
        if($res1 == true && $res2 == true){
            return true;
        }
        elseif($res1 != true && $res2 != true){
            return array_merge($res1, $res2);
        }
        elseif($res1 != true){
            return $res1;
        }
        else{
            return $res2;
        }
    }
}

?>
