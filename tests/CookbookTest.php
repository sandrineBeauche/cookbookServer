<?php

require_once __DIR__ ."/../vendor/autoload.php";
require_once __DIR__ ."/../bootstrap.php";

use Guzzle\Http\Client;
use Guzzle\Plugin\Cookie\CookiePlugin;
use Guzzle\Plugin\Cookie\CookieJar\ArrayCookieJar;

/**
 * Description of CookbookTest
 *
 * @author Asus
 */
abstract class CookbookTest extends PHPUnit_Extensions_Database_TestCase {
    
    protected static $client;
    
    protected static $RecipeQuery = "RecipeQuery";
    protected static $RecipeStepsQuery = "RecipeStepsQuery";
    protected static $UserQuery = "UserQuery";
    protected static $CountryQuery = "countryQuery";
    protected static $IngredientQuery = "ingredientQuery";
    protected static $IngredientTypeQuery = "ingredientTypeQuery";
    protected static $RecipeTypeQuery = "recipeTypeQuery";
    protected static $UnitQuery = "unitQuery";
    
    public function getConnection(){
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=cookbook', 'devuser', 'devpass', array());
        return $this->createDefaultDBConnection($pdo, 'cookbook');
    }
    
    
    protected function generateDataset(array $datasetFiles){        
        $datasets = array();
        foreach($datasetFiles as $currentDataset){
            $datasets[] = new PHPUnit_Extensions_Database_DataSet_YamlDataSet(
                dirname(__FILE__)."/datasets/".$currentDataset
            );
        }
        
        $compositeDs = new PHPUnit_Extensions_Database_DataSet_CompositeDataSet($datasets);
        return $compositeDs;
    }
    
    
    public static function setUpBeforeClass(){
        self::$client = new Client('http://localhost/MyCookbook/server/api/');
        
        $cookiePlugin = new CookiePlugin(new ArrayCookieJar());
        self::$client->addSubscriber($cookiePlugin);
    }
    
    public function setUp() {
        parent::setUp();
        RecipePeer::$instances = array();
        RecipeStepsPeer::$instances = array();
        UserPeer::$instances = array();
        countryPeer::$instances = array();
        ingredientPeer::$instances = array();
        ingredientTypePeer::$instances = array();
        recipeTypePeer::$instances = array();
        unitPeer::$instances = array();
    }
    
    
    
    protected function login($username, $password){
        $request = self::$client->post('login.php', null, array(
            'username' => $username,
            'password' => $password
        ));

        try{
            $response = $request->send();
        }
        catch(Exception $ex){
            $response = $ex->getResponse();
        }
        return $response;
    }
    
    
    protected function verifyOk($response, $status = 200){
        $this->assertEquals($status, $response->getStatusCode());
    }
    
    
    protected function verifyErrorMessage($response, $code, $message, $status = 200){
        $this->assertEquals($status, $response->getStatusCode());
        $result = $response->json();
        $this->assertArrayHasKey("errors", $result);
        $this->assertArrayHasKey($code, $result["errors"]);
        $this->assertEquals($message, $result["errors"][$code]);
    }
    
    
    protected function verifyDatabaseNoChange() {
        $names = $this->getDataSet()->getTableNames();
        
        foreach ($names as $table){
            $queryTable = $this->getConnection()->createQueryTable(
                $table, 'SELECT * FROM '.$table
            );
            $expectedTable = $this->getDataSet()->getTable($table);
            $this->assertTablesEqual($expectedTable, $queryTable);
        }
    }
    
    protected function withAcessDenied($args){
        $this->login("sandrine.beauche@sfr.fr", "toto");
        
        $request = $this->prepareRequest($args);
        
        try{
            $request->send();
            $this->fail();
        }
        catch(Exception $ex){
            $response = $ex->getResponse();
            $this->assertEquals(401, $response->getStatusCode());
            $this->verifyDatabaseNoChange();
        }
    }
    
    protected function withNotFound($args, $login = false){
        if($login){
            $this->login("sandrine.beauche@gmail.com", "toto");
        }
        
        $request = $this->prepareRequest($args);
        
        try{
            $request->send();
            $this->fail();
        }
        catch(Exception $ex){
            $response = $ex->getResponse();
            $this->assertEquals(500, $response->getStatusCode());
        }
    }
    
    protected abstract function prepareRequest($args);
    
    
    protected function withJsonResult($args, $expectedJson, $login = false){
        if($login){
            $this->login("sandrine.beauche@gmail.com", "toto");
        }
        
        $request = $this->prepareRequest($args);
        
        $response = $request->send();
        $data = $response->json();
 
        $expected = json_decode($expectedJson, true);
        
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals($expected, $data);
    }
    
    
    protected function executeRequest($args, $login = false){
        if($login){
            $this->login("sandrine.beauche@gmail.com", "toto");
        }
        $request = $this->prepareRequest($args);
        return $request->send();
    }
    
    
    protected function verifyDeleted($queryName, $id){
        $reflectionMethod = new ReflectionMethod($queryName, 'create');
        $query = $reflectionMethod->invoke(null);
        
        $item = $query->findPk($id);
        if(isset($item)){
            $this->fail();
        }
    }
}

?>
