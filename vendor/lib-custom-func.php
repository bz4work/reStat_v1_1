<?php
/**
 * Created by PhpStorm.
 * User: slim
 * Date: 13.05.2016
 * Time: 15:26
 */

/**
 * @param $name
 * @return mixed
 * @throws Exception
 */

function myAutoloadClass($name){
    $dir = dirname(__DIR__);
    $ds = DIRECTORY_SEPARATOR;

    $path_controller = $dir.$ds."controller".$ds;
    $path_model = $dir.$ds."model".$ds;
    $path_view = $dir.$ds."view".$ds;
    $path_config = $dir.$ds."config".$ds;

    if (file_exists($path_controller.$name.".php")){
        $contr = $path_controller.$name.".php";
        return include "$contr";

    }elseif(file_exists($path_model.$name.".php")){
        $model = $path_model.$name.".php";
        return include "$model";

    }elseif(file_exists($path_view.$name.".php")){
        $view = $path_view.$name.".php";
        return include "$view";

    }elseif(file_exists($path_config.$name.".php")){
        $config = $path_config.$name.".php";
        return include "$config";
    }else{
        throw new Exception ("class: $name does not exist, ".__FUNCTION__.", line:".__LINE__);
    }
}

spl_autoload_register("myAutoloadClass");