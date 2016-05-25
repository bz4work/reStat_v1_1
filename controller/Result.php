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
        foreach ($arrParam as $k=>$v) {
            if ($k != 'name'){
                $controller = $k;
                $method = $v;
            }
        }
        $name = $arrParam['name'];

        unset($_SESSION[$name]);

        Redirect::redirect("index.php?$controller=$method");
    }

    public function destroyLocal($arrParam){
        foreach ($arrParam as $k=>$v) {
            if ($k != 'name'){
                $controller = $k;
                $method = $v;
            }
        }
        $name = $arrParam['name'];

        unset($_SESSION[$name]);

        Redirect::redirect("index.php?$controller=$method");
    }

}