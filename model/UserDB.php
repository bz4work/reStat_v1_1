<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:29
 */
class UserDB
{
    public $userData;

    public function __construct(){}

    public function generateUserDataArray ($user_email=null, $column_table="email"){
        if (isset($user_email) && !empty($user_email)) {
            $sql = "SELECT * FROM users
                                WHERE ".$column_table."='" . $user_email . "';";
            try{
                $arr = WorkDB::getData($sql);
            }catch(Exception $e){
                //если поймали исключение "Записей нет", отдаем false
                return "false";
            }

            $this->userData = $arr[0];
        }else{

            $log = new Log();
            $log->writeToFile(__METHOD__,__FILE__,__LINE__,$user_email,$column_table);

            throw new Exception ("Не передано имя пользователя и/или имя колонки не верное");
        }
    }

    public function getUserInfo($key){
        if (isset($this->userData[$key])){
            return $this->userData[$key];
        }else{
            $log = new Log();
            $log->writeToFile(__METHOD__,__FILE__,__LINE__,$key);

            throw new Exception ("Не удалось получить данные юзера, переданный ключ не существует.");
        }

    }
}