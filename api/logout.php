<?php
session_start();

require_once '../bootstrap.php';

if(array_key_exists("accountType", $_SESSION)){
    unset($_SESSION["accountType"]);
    $id = $_SESSION["idUser"];
    unset($_SESSION["idUser"]);
    
    $user = UserQuery::create()->findPk($id);
    if($user->getkey() != null){
        $user->setkey(null);
        $user->save();
    }
}
else {
    http_response_code(400);
    echo json_encode(array("message" => "Vous n'etes actuellement pas logue"));    
}

?>
