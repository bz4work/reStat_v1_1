<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 19.05.2016
 * Time: 9:52
 */

/**
 * Class WorkDB
 */
class WorkDB{

    /**
     * @param $sql
     * @return array
     * @throws Exception
     */
    static public function getData ($sql){
        $res_data = array();

        $connect = DB::getDB();

        if (isset($connect->connect_error)){
            //return ErrorController::createErr('no connect to DB');
            throw new Exception (
                "Error: ".$connect->connect_error.'.<br> Error code: '.$connect->connect_errno);
            exit();
        }


        if ($result = DB::getDB()->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $res_data[] = $row;
            }

            if (count($res_data) == 0) {
                return false;
            }else{
                return $res_data;
            }

        }else{
            throw new Exception ("Не удалось выполнить запрос к БД");
        }

    }

    /**
     * insert, update, delete only. Not return result
     * @param $sql
     * @return bool
     * @throws Exception
     */
    static public function insertData($sql){
        if ($result = DB::getDB()->query($sql)){
            return true;
        }else{
            return false;
        }
    }
}