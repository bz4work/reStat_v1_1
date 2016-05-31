<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 16.05.2016
 * Time: 18:36
 * @property string _route
 */
class Router{
    private static $_route;

    public static function getRoute(){
        return self::$_route;
    }

    public static function setRoute($route){
        self::$_route = $route;
    }

    public function create(){
        $url = self::getRoute();

        //если строка пустая или передано index.php
        //загружаем контроллер=метод поумолчанию
        if($url === "/" || $url === "/index.php"){

            $controller = Config::getConfig('defaultController');
            $method = Config::getConfig('defaultMethod');
            $params = array();

        }else{
            $cut_url = explode('?',$url);

            //если после {контроллера=метода} переданы параметры после знака & ->
            // -> разбиваем строку по этому знаку

            //в ячейке $cut_url[1] - лежит часть строки после занка ?
            if(stristr($cut_url[1],"&")){
                $parts = explode('&',$cut_url[1]);

                //get Controller and Method
                $controllerMethodString = array_shift($parts);
                $part = explode('=',$controllerMethodString);
                $controller = $part[0];
                $method = $part[1];

                //get Array Params like ([param_name1]=>[value_param1],[param_name2]=>[value_param2])
                $params = array();
                foreach ($parts as $row) {
                    $arrNameVal = explode('=',$row);
                    //$arrNameVal[0] - name param
                    //$arrNameVal[1] - value param
                    $params[$arrNameVal[0]] = $arrNameVal[1];
                }

            }else{
                $parts = explode('=',$cut_url[1]);
                $controller = array_shift($parts);
                $method = array_shift($parts);

                //ignoring XDEBUG_SESSION_START
                if($controller == "XDEBUG_SESSION_START") {
                    $controller = Config::getConfig('defaultController');
                    $method = Config::getConfig('defaultMethod');
                }
            }//конец вложенного else

        }//конец 1го else

        $controllerName = ucfirst($controller);
        $reflexion = new ReflectionClass("$controllerName");

        $object = new $controllerName;

        if(!$checkMethod = $reflexion->getMethod("$method")){
            throw new Exception ("method: $method does not exist: ".__LINE__);
        }

        if (isset($params)){
            return $object->$method($params);
        }else{
            return $object->$method();
        }
    }

}