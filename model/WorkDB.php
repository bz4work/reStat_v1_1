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
    public static function getData ($sql){
        $res_data = array();

        if ($result = DB::getDB()->query($sql)) {
            while ($row = $result->fetch_assoc()) {
                $res_data[] = $row;
            }


            if (count($res_data) == 0) {
                throw new Exception ("Записей нет.");
            }else{
                return $res_data;
            }

        }else{
            $log = new Log();
            $log->writeToFile(__METHOD__,__FILE__,__LINE__,$sql);

            throw new Exception ("Не удалось выполнить запрос к БД");
        }

    }

    /**
     * insert, update only. No return result
     * @param $sql
     * @return bool
     * @throws Exception
     */
    public function insertData($sql){
        if ($result = DB::getDB()->query($sql)){
            return true;
        }else{
            throw new Exception ("Не удалось выполнить запрос в методе:".__METHOD__.
                ". Проверить правильность запроса: ". $result->error);
        }
    }
}