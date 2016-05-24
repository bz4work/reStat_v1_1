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
        return $renderViewRefill->render("about");
    }

    public function main($options_param = array()){

        /**
         * if you need income parameters -> use this:
         *
         * if (isset($options_param)){ extract($options_param);}
         *
         */

        $renderViewRefill = new View();
        return $renderViewRefill->render("main");
    }

    /*public function emptyPage(){
        $renderViewRefill = new View();
        return $renderViewRefill->renderEmptyPage("empty");
    }*/
}