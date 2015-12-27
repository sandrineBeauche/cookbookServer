<?php

session_start();

require_once '../bootstrap.php';
require '../services/UserService.php';

$userService = new UserService();

if(array_key_exists("username", $_POST)){
    $username = $_POST["username"];
    $password = $_POST["password"];

    if ($username != "" && $password != "") {
        $encryptedPassword = crypt($password, $userService->passphrase);
        $currentUser = UserQuery::create()->findOneByUsernameAndPassword($username, $encryptedPassword);
        if(array_key_exists("stayConnected", $_POST)){
            $stayConnected = $_POST["stayConnected"];
        }
        else{
            $stayConnected = "off";
        }
    }
}
else{
    $key = $_POST["key"];
    $currentUser = UserQuery::create()->findOneBykey($key);
    $stayConnected = "on";
}

if (isset($currentUser)) {
    $result = $userService->loginUser($currentUser, $stayConnected);
    echo json_encode($result);
} else {
    http_response_code(401);
}

?>
