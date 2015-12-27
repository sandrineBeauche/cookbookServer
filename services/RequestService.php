<?php

/**
 * Description of RequestService
 *
 * @author Asus
 */
class RequestService {
    
    public static function processPutParams(){
        $result  = array(); 
        parse_str(file_get_contents('php://input'), $result);
        return $result;
    }
}

?>
