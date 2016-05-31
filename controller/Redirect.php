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
        if ($url === "previous"){
            if(isset($_SERVER['HTTP_REFERER'])){
                $url = $_SERVER['HTTP_REFERER'];
            }else{
                $url = "/";
            }

        }
        return header ("Location: $url");
    }

    public function refIndexLoad(){
        if (isset($_SESSION['user'])){

            try{
                $url = Config::getConfig('refIndex');
                return self::redirect($url);
            }catch(Exception $e){
                $err_txt = $e->getMessage();
                Result::errorCreate("globalError", $err_txt);
                return self::redirect('previous');
            }

        }else{
            $url_logn_form = Config::getConfig("logCheck");
            self::redirect($url_logn_form);
        }
    }

    public function siIndexLoad(){
        if (isset($_SESSION['user'])){

            try{
                $url = Config::getConfig('servInterIndex');
                return self::redirect($url);
            }catch(Exception $e){
                $err_txt = $e->getMessage();
                Result::errorCreate("globalError", $err_txt);
                return self::redirect('previous');
            }

        }else{
            $url_logn_form = Config::getConfig("logCheck");
            self::redirect($url_logn_form);
        }
    }


}