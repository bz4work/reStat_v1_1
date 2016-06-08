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

    public function generateUserDataArray ($user_email=null, $column_table="email"){
        if (isset($user_email) && !empty($user_email)) {
            $sql = "SELECT * FROM users
                                WHERE ".$column_table."='" . $user_email . "';";
            try{
                $arr = WorkDB::getData($sql);
                $this->userData = $arr[0];
            }catch(Exception $e){
                //если поймали исключение "Записей нет", отдаем false
                return "false";
            }
        }else{
            throw new Exception ("Не передано имя пользователя и/или имя колонки не верное");
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