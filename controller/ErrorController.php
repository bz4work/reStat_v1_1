<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 08.06.2016
 * Time: 3:44
 */
class ErrorController
{
    public static function createErr($msg){
        $_SESSION['msg']['error'] = null;
        if ($_SESSION['msg']['error'] != $msg){
            $_SESSION['msg']['error'] = $msg;
        }
    }

    public static function createSuccess($msg){
        $_SESSION['msg']['success'] = null;
        if ($_SESSION['msg']['success'] != $msg){
            $_SESSION['msg']['success'] = $msg;
        }
    }

    public static function destroyMsg($arrName){
        if (isset($arrName)) {
            $name = $arrName['name'];
            unset($_SESSION['msg'][$name]);
            Redirect::redirect("previous");
        }
    }
}