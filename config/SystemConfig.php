<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 25.05.2016
 * Time: 22:23
 */
class SystemConfig extends Config
{
    public static function initConfig($fileNameConfig = "sysconfig.ini"){
        $config = parse_ini_file($fileNameConfig);
        if(static::setConfig($config)){
            return true;
        }else{
            throw new Exception ("не удалось сохранить настроики методом setConfig");
        }

    }
}