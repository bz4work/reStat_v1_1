<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 23:22
 */
class UserProfileModel
{
    /**
     * returns amount last Refill for concrete user
     *
     * @param $user_id
     * @return string
     * @throws Exception
     */
    static public function getLastAmount($user_id){
        $sql = "SELECT date,total_sum FROM refill WHERE id_user = $user_id ORDER BY id DESC LIMIT 1;";
        $arr = WorkDB::getData($sql);
        if($arr){
            $lastAmount = $arr[0]['total_sum'];
        }else{
            $lastAmount = '{no data}';
        }
        return $lastAmount;
    }

    /**
     * returns last date of Refill for concrete user
     *
     * @param $user_id
     * @return string
     * @throws Exception
     */
    static public function getLastDate($user_id){
        $sql = "SELECT date FROM refill WHERE id_user = $user_id ORDER BY id DESC LIMIT 1;";
        $arr = WorkDB::getData($sql);
        if($arr){
            $lastDate = $arr[0]['date'];
        }else{
            $lastDate = '{empty}';
        }
        return $lastDate;
    }
}