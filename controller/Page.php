<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 19.05.2016
 * Time: 12:27
 */
class Page
{
    public function __construct(){

    }

    public function about(){
        $renderViewRefill = new View();

        if (isset($_SESSION['id'])){
            $reserve = RefillRecordAction::getRideReserve($_SESSION['id']);
        }
        if(isset($reserve)){
            $_SESSION['balance'] = $reserve;
        }else{
            $_SESSION['balance'] = 'нет данных';
        }

        return $renderViewRefill->render("about");
    }

    public function main($options_param = array()){

        /**
         * if you need income parameters -> use this:
         *
         * if (isset($options_param)){ extract($options_param);}
         *
         */
        if (isset($_SESSION['id'])){
            $reserve = RefillRecordAction::getRideReserve($_SESSION['id']);
        }
        if(isset($reserve)){
            $_SESSION['balance'] = $reserve;
        }else{
            $_SESSION['balance'] = 'нет данных';
        }

        $renderViewRefill = new View();
        return $renderViewRefill->render("main");
    }

    public function aboutRefill(){
        $renderViewRefill = new View();
        return $renderViewRefill->render("aboutRefill");
    }

    public function aboutIntervals(){
        $renderViewRefill = new View();
        return $renderViewRefill->render("aboutIntervals");
    }
}