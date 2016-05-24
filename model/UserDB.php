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

    public function __construct($search_data=null, $column_table="email"){
        if (isset($search_data) && !empty($search_data)) {
            $sql = "SELECT * FROM users
                                WHERE ".$column_table."='" . $search_data . "';";
            try{
                $arr = WorkDB::getData($sql);
            }catch(Exception $e){
                return $e->getMessage();
            }

            $this->userData = $arr[0];
        }else{

            $log = new Log();
            $log->writeToFile(__METHOD__,__FILE__,__LINE__,$search_data,$column_table);

            throw new Exception ("Не передано имя пользователя и/или имя колонки не верное");
        }
    }

    public function getUserInfo($key){
        if (isset($this->userData[$key])){
            return $this->userData[$key];
        }else{
            $log = new Log();
            $log->writeToFile(__METHOD__,__FILE__,__LINE__,$key);

            throw new Exception ("Не удалось получить данные юзера");
        }

    }
}