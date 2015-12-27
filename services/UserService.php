<?php



/**
 * Description of UserService
 *
 * @author Asus
 */
class UserService {

    public $passphrase = "passphrasesecrete";
    
    public static $ADMIN = 1;
    public static $CONTRIBUTOR = 2;
    public static $MEMBER = 3;
    
    private static $ADMIN_NAME = "Gerant";
    private static $CONTRIBUTOR_NAME = "Cuistot";
    private static $MEMBER_NAME = "Gourmand";


    public static function verifyAccessRight($minAccessRight) {
        if (array_key_exists("accountType", $_SESSION)) {

            $result = ($_SESSION["accountType"] <= $minAccessRight);
            return $result;
        } else {
            echo json_encode(array("result" => "Vous n'etes pas logue"));
            return false;
        }
    }

    
    public static function withRole($minAccessRight, $exec){
        if(UserService::verifyAccessRight($minAccessRight)){
            $exec();
        }
        else{
            http_response_code(401);
        }            
    }
    
    
    public static function getAccountTypeName($user){
        switch ($user->getAccountType()){
            case static::$ADMIN:
                return static::$ADMIN_NAME;
            case static::$CONTRIBUTOR:
                return static::$CONTRIBUTOR_NAME;
            case static::$MEMBER:
                return static::$MEMBER_NAME;
        }
    }
    
    public static function loginUser($user, $stayConnected){
        $_SESSION["accountType"] = $user->getAccountType();
        $_SESSION["idUser"] = $user->getid();
        $result = array("username" => $user->getUsername(),
                        "accountType" => $user->getAccountType(),
                        "accountTypeName" => UserService::getAccountTypeName($user));
        
        if($stayConnected == "on"){
            $key = uniqid();
            $key = $key.md5($key);
            
            $user->setkey($key);
            $user->save();
            
            $result["key"] = $key;
        }
        
        return $result;
    }
}

?>
