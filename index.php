<?php
/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 16.05.2016
 * Time: 18:33
 */
session_start();
error_reporting(-1);

include_once "./vendor/lib-custom-func.php";

Config::initConfig("config.ini");

date_default_timezone_set(Config::getConfig("timezone"));

try{
    $router = new Router();
    $router->setRoute($_SERVER['REQUEST_URI']);
    $router->create();

}catch(Exception $e){
    echo $e->getMessage();
}


