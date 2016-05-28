<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 24.05.2016
 * Time: 14:44
 */
class Result{

    static public function successCreate($var_name,$value){
        $_SESSION[$var_name] = $value;
    }

    static public function errorCreate($var_name,$value){
        $_SESSION[$var_name] = $value;
    }

    public function destroyGlobal($arrParam){
        $name = $arrParam['name'];
        unset($_SESSION[$name]);
        Redirect::redirect($_SERVER['HTTP_REFERER']);

    }

    public function destroyLocal($arrParam){
        $name = $arrParam['name'];
        unset($_SESSION[$name]);
        Redirect::redirect($_SERVER['HTTP_REFERER']);
    }

    public function clearAll(){
        $this->destroyGlobal("globalError");
        /*static::destroyGlobal("globalResult");
        static::destroyLocal("add_error");
        static::destroyLocal("add_result");*/
    }
}