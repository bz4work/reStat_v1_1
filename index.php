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
require_once 'vendor/autoload.php';

SystemConfig::initConfig("sysconfig.ini");
Config::initConfig("config.ini");

Config::initConfig("mod_rewrite.ini");

date_default_timezone_set(Config::getConfig("timezone"));

try{
    $router = new RouterNew();
    $router->setRoute($_SERVER['REQUEST_URI']);
    $router->create();
}catch(Exception $e){
    echo $e->getMessage();
}


