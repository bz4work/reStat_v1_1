<?php

class RouterNew extends Router{
    /*private static $_route;*/

    public function create(){

        //restat.loc/controller/method/param_name1/value1/param_name2/value2
        //restat.loc - /
        //restat.loc/refill/index/  -  /refill/index/
        //restat.loc/refill/index  -  /refill/index


        if (stristr(self::getRoute(),"?")){
            $route = explode("?",self::getRoute());

            self::setRoute($route[0]);
        }

        if (self::getRoute() == "/"){
            $default_url = Config::getConfig("defaultRoute");
            $route = explode("/",trim($default_url,'/'));

            $controller = $route[0];
            $method = $route[1];
        }else{
            $url = self::getRoute();
            $routes = explode("/",trim($url,'/'));
            $controller = array_shift($routes);
            $method = array_shift($routes);

            //если в массиве остались значения:
            //значения с парных ячеек массива пишем в первый массив
            //значения с НЕ парных ячеек массива пишем во второй массив
            //через array_combine первый массив используем как ключи массива
            //второй массив используем как значения массива
            if( count($routes) ) {
                foreach ($routes as $k => $v) {
                    if ($k % 2) {
                        $arr_v[] = $v;
                    } else {
                        $arr_k[] = $v;
                    }
                }
                $params = array_combine($arr_k, $arr_v);
            }
            //конец блока формирования параметров
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


}