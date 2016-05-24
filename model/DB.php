<?php

/**
 * Created by PhpStorm.
 * User: Slava
 * Date: 04.05.2016
 * Time: 13:44
 */
class DB{
    static private $_db = null;

    private function __construct(){
    }

    private function __clone(){
    }

    /**
     * @return mysqli|null
     * @throws Exception
     */
    static public function getDB()
    {
        return
            self::$_db == null

                ? self::$_db = new mysqli(Config::getConfig('db_host'), Config::getConfig('db_user'),
                Config::getConfig('db_pass'), Config::getConfig('db_name'))

                : self::$_db;
    }
}