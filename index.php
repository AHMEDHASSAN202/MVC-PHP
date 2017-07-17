<?php
/**
 * New MVC Project
 *
 * Created by PhpStorm.
 * User: AHMED
 * Date: 7/6/2017
 * Time: 4:46 PM
 */

//=================== Application Configuration =================\\

$configFile  = 'config.php';    //main config file
$configClass = 'vendor/System/Config.php';  //config class

if (!file_exists($configFile) OR !file_exists($configClass)) {
    die('Not Found Configuration Files');
}

require_once $configFile;   //required config file
require_once $configClass;  //required config class

System\Config::phpCheckVersion();
System\Config::statusErrors();


//================= #END# Configuration ====================\\

use System\App;
use System\File;

require_once 'vendor/System/file.php';
require_once 'vendor/System/App.php';


$app = App::getInstance(new File(__DIR__));

$app->run();    //run application
