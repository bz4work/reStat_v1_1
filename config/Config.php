<?php

/**
 * Created by PhpStorm.
 * User: Slava
 * Date: 04.05.2016
 * Time: 13:45
 */
class Config{

    private static $_config;

    private function __construct(){
    }

    private function __clone(){
    }

    private function __sleep(){
    }

    /**
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public static function getConfig($key)
    {
        if (!array_key_exists($key, self::$_config)){
            throw new Exception ("нет такого параметра: ".$key."\n");
        }
        return self::$_config[$key];
    }

    public static function setConfig($param, $value_param=""){
        if(isset($param) && is_array($param)){
            foreach ($param as $k => $v) {
                self::$_config[$k] = $v;
            }
            return true;
        }elseif(isset($param)&& is_string($param)){
            self::$_config["$param"] = $value_param;
            return true;
        }else{
            throw new Exception ("Проверьте переданные значения");
        }
    }

    /**
     * @param string $fileNameConfig
     * @return bool
     * @throws Exception
     */
    public static function initConfig($fileNameConfig = "config.ini"){
        $config = parse_ini_file($fileNameConfig);
        if(self::setConfig($config)){
            return true;
        }else{
            throw new Exception ("не удалось сохранить настроики методом setConfig");
        }

    }

}