<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 14:56
 */
class Redirect{
    public function __construct()
    {
    }

    public static function redirect($url = "empty"){
        if ($url === "empty"){
            $url = $_SERVER['HTTP_REFERER'];
        }
        return header ("Location: $url");
    }
}