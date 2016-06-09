<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:29
 */
class UserGetInfoModel
{
    public $userData;

    public function __construct(){}

    public function generateUserDataArray($user_email = null, $column_table = "email"){
        /*if (!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }*/

        $sql = "SELECT * FROM users
                                WHERE $column_table = '$user_email';";

        $arr = WorkDB::getData($sql);
        if (is_array($arr)){
            $this->userData = $arr[0];
        }else{
            return "false";
        }

    }

    public function getUserInfoValue($key,$value=null){
        //поиск по ключу+значению
        if(isset($value)){
            if ($this->userData[$key] == $value){
                return $this->userData[$key];
            }
        //поиск только по ключу если не передано значение
        }elseif (isset($this->userData[$key])){
            return $this->userData[$key];
        }else{
            return false;
        }

    }
}