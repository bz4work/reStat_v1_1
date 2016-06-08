<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 08.06.2016
 * Time: 3:44
 */
class ErrorController
{
    public static function createErr($msg,$key){
        $_SESSION['error'] = null;
        if ($_SESSION['error'][$key] != $msg){
            $_SESSION['error'][$key] = $msg;
        }
    }
}