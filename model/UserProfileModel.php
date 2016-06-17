<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 17.06.2016
 * Time: 16:00
 */
class UserProfileModel
{
    public function setNotifyOff($user_id,$id_record){
        if(!isset($user_id) || empty($user_id)){
            throw new Exception ("error 119: ".__METHOD__);
        }

        $sql = "UPDATE service_intervals SET notify = 'no' WHERE id = $id_record;";
        if(WorkDB::insertData($sql)){
            $res = true;
        }else{
            $res = false;
        }
        return $res;
    }
}