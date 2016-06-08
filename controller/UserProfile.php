<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 23:16
 */
class UserProfile
{
    public function startPage(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            Result::errorCreate("globalError","Эта страница Вам не доступна, войдите.");
            return Redirect::redirect(Config::getConfig("logCheck"));
        }
        $view = new View();
        $data = new UserProfileModel();

        //$data->getPersonalData($_SESSION['user']);
        $data = [ "name" => "slava",
                  "zapas" => "200",
                  "nextRefill" =>"2015-05-13",
                  "lastRefill" => "2015-04-29",
                  "lastAverageRate" => "13.75 л/100км"];

        $moduleName = "userProfile";

        $view->render($moduleName,$data=array(),$url=array());
    }
}