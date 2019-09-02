<?php
//cors
header('Access-Control-Allow-Origin:*');
header('Access-Control-Allow-Methods: GET, POST, PUT,DELETE,OPTIONS,PATCH');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

//define
define('APP_NAME', 'App');
define('APP_PATH', './App/');
define('APP_DEBUG', true);

//bootstrap
require './ThinkPHP/ThinkPHP.php';