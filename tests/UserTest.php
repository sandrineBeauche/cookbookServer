<?php

require_once "../vendor/autoload.php";

require_once '../services/UserService.php';

require_once "CookbookTest.php";

class UserTest extends CookbookTest {
    

    protected function getDataSet(){    
        return new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
            dirname(__FILE__)."/datasets/users.yml"
        );
    }
    
    
    public function testLoginSuccess(){
        $response = $this->login('sandrine.beauche@gmail.com', 'toto');
        $data = $response->json();
        
        $expected = array("username" => "sandrine.beauche@gmail.com",
                            "accountType" => 1,
                            "accountTypeName" => "Gerant");
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $data);
    }
    
    public function testLoginFail(){
        $response = $this->login('sandrine.beauche@gmail.com', 'titi');
        
        $data = $response->json();
        
        $this->assertEquals(401, $response->getStatusCode());
    }
    
    
    
    public function testAsAdmin(){
        $userService = new UserService();
        $_SESSION["accountType"] = UserService::$ADMIN;
        
        $result = $userService->verifyAccessRight(UserService::$CONTRIBUTOR);
        $this->assertEquals(true, $result);
    }
    
    
    public function testAsContributor(){
        $userService = new UserService();
        $_SESSION["accountType"] = UserService::$CONTRIBUTOR;
        
        $result = $userService->verifyAccessRight(UserService::$CONTRIBUTOR);
        $this->assertEquals(true, $result);
    }
    
    public function testAsMember(){
        $userService = new UserService();
        $_SESSION["accountType"] = UserService::$MEMBER;
        
        $result = $userService->verifyAccessRight(UserService::$CONTRIBUTOR);
        $this->assertEquals(false, $result);
    }

    protected function prepareRequest($args) {
        return null;
    }
}

?>
