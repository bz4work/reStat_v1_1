<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:53
 */
class Session{
    private $_username;

    public function __construct($name,$value){
        //$this->_username = $name;
        return $_SESSION["$name"] = $value;
    }

    public function getSession($name){
        return $this->_username[$name];
    }

}