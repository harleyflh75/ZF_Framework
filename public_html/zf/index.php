<?php
// Define application name
defined('APPLICATION_NAME')
    || define('APPLICATION_NAME', (getenv('APPLICATION_NAME') ? getenv('APPLICATION_NAME') : 'NOT_SET'));

// Define path to application directory
defined('APPLICATION_PATH')
    || define('APPLICATION_PATH', realpath(dirname(__FILE__) . '/../../application/'.APPLICATION_NAME.'/'));

// Define application environment. '/../../application/'.APPLICATION_NAME.'/'
defined('APPLICATION_ENV')
    || define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'development'));

if(APPLICATION_ENV == "development"){
    $dev_path = '/..';
}else{
    $dev_path = '';
}

// Ensure library/ is on include_path
set_include_path(implode(PATH_SEPARATOR, array(
    realpath(APPLICATION_PATH . '/../../library/'),
    realpath(APPLICATION_PATH . $dev_path. '/../../Zend/1.10.6/'),
    get_include_path(),
)));
//echo get_include_path() .' => '.realpath(APPLICATION_PATH) .' => '. APPLICATION_PATH;
/** Zend_Application */
require_once 'Zend/Application.php';  

// Create application, bootstrap, and run
$application = new Zend_Application(
    APPLICATION_ENV, 
    APPLICATION_PATH . '/configs/application.ini'
);
$application->bootstrap()
            ->run();