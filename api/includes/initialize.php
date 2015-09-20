<?php

//Define the core paths
//Define them as absolute paths to make sure that require_once works as expected

//DIREcTORY_SEPARATOR is a PHP pre-defined constant
//(\ for Windows, / for Unix)

//Localhost
define('DS', DIRECTORY_SEPARATOR);
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']);
define('SITE_ROOT', $_SERVER["DOCUMENT_ROOT"].DS.'FlashApp'.DS.'api');
define('LIB_PATH', SITE_ROOT.DS.'includes');
define('LOCAL_SECRET', file_get_contents(DOCUMENT_ROOT.DS.'../secret/key.txt'));
define('DOMAIN', 'localhost');

//Top Dog
/*
define('SITE_ROOT', $_SERVER["DOCUMENT_ROOT"].DS.'samples'.DS.'Top-Dog-Daycare'.DS.'api');
define('LIB_PATH', SITE_ROOT.DS.'includes');
define('LOCAL_SECRET', file_get_contents(DOCUMENT_ROOT.DS.'../../secret/topdog/key.txt'));

*/
//load config file first
require_once(LIB_PATH.DS."config.php");

//load basic functions next so that everything after can use them
require_once(LIB_PATH.DS."functions.php");

//load core objects
require_once(LIB_PATH.DS."session.php");
require_once(LIB_PATH.DS."database.php");

//load database related classes
require_once(LIB_PATH.DS."hash.php");
require_once(LIB_PATH.DS."user.php");
require_once(LIB_PATH.DS."location.php");
require_once(LIB_PATH.DS."jobs.php");
?>