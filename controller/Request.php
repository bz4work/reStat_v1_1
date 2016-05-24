<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 12:14
 */
class Request{
    /**
     * @param $key
     * @return bool
     */
    public static function getPost($key)
    {
        if (isset($_POST[$key])) {
            return $_POST[$key];
        } else {
            return false;
        }
    }

    public static function getSession($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }
}