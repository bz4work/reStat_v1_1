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

    public function create(){

        $controller = null;
        $method = null;
        $params = array();

        //Router with non ModRewrite
        ///bz4work/test/mvc/index.php? refill=index & username=slava & id=1
        if (!stristr(self::getRoute(),"?")){
            self::setRoute(Config::getConfig("defaultRoute"));
            $url = explode("=",self::getRoute());
            $controller = $url[0];
            $method = $url[1];
        }else{
            $url = explode("?",self::getRoute());
            $controllerArray = explode("&",$url[1]);

            foreach ($controllerArray as $key=>$row) {
                if($key == 0){
                    $str = explode("=",$row);

                    $controller .= $str[0];
                    $method .= $str[1];

                }else{
                    $str = explode("=",$row);
                    if ($str[0] == "XDEBUG_SESSION_START") {

                    }else{
                        $params["$str[0]"] = $str[1];
                    }
                }
            }
        }

        $controllerName = ucfirst($controller);
        $content = new $controllerName;

        $reflexion = new ReflectionClass("$controllerName");

        if(!$checkMethod = $reflexion->getMethod("$method")){
            throw new Exception ("Такого метода не существует".__LINE__);
        }

        if (isset($params)){
            return $content->$method($params);
        }else{
            return $content->$method();
        }
    }

    public static function getRoute(){
        return self::$_route;
    }

    public static function setRoute($route){
        self::$_route = $route;
    }

}