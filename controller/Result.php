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

    public function destroyMsg($arrParam){
        $name = $arrParam['name'];
        unset($_SESSION[$name]);
        Redirect::redirect("previous");

    }

    public function clearAll(){
        $this->destroyGlobal("globalError");

    }
}