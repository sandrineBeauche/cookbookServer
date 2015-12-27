<?php

// Include the main Propel script
require_once 'vendor/propel/propel1/runtime/lib/Propel.php';

    
Propel::init(__DIR__ ."/build/conf/cookbook-conf.php");

// Add the generated 'classes' directory to the include path
set_include_path(__DIR__ ."/build/classes" . PATH_SEPARATOR . get_include_path());
set_include_path(__DIR__ ."/utils" . PATH_SEPARATOR . get_include_path());

?>