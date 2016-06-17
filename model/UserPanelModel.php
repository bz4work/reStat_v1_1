<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 23:22
 */
class UserPanelModel
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
            $lastDate = '{no data}';
        }
        return $lastDate;
    }

    /**
     * @param $user_id
     * @return float|string
     * @throws Exception
     */
    static public function nextRefill($user_id){
        $sql = "SELECT total_liters
                    FROM refill WHERE id_user = $user_id
                    ORDER BY id DESC LIMIT 1;";
        $arr = WorkDB::getData($sql);
        if($arr){
            $liters = $arr[0]['total_liters'];
        }else{
            $liters = 0;
        }

        if($liters == 0){
            $nextRefillDate = '{no data}';
        }else {
            $fuel_economy = UserSettingsModel::getValueSetting('fuel_economy', $user_id);
            $mileage_per_day = UserSettingsModel::getValueSetting('mileage_per_day', $user_id);
            $reserve_days = $liters / ($mileage_per_day * ($fuel_economy / 100));

            $lastDate = self::getLastDate($user_id);

            //0-y  1-m  2-d
            $arrDate = explode('-', $lastDate);

            //hour-min-sec - m-d-y
            $timeMark = mktime(($reserve_days*24), 0, 0, $arrDate['1'], $arrDate['2'], $arrDate['0']);
            $nextRefillDate = date('Y-m-d', $timeMark);
        }
        return $nextRefillDate;
        //return $reserve_days;

    }

    static public function getLastSevices ($user_id,$count=null){
        $sql = "SELECT ni.name AS service, si.finish_odo AS odo, si.notify,si.id
                FROM service_intervals AS si
                JOIN name_intervals AS ni
                ON si.name = ni.id
                WHERE si.id_user = '$user_id' AND si.notify = 'yes'
                ORDER BY si.id DESC;";

        $lastRide = self::getLastOdometrValue($user_id);

        $arr = WorkDB::getData($sql);
        if($lastRide != 0){
            if($arr) {
                foreach ($arr as $k => $item) {
                   // if ($item['notify'] == 'yes') {
                        if ($lastRide < ($item['odo'] - 300)) {
                            unset($arr[$k]);
                        }
                   // }
                }
            }
        }

        $lastServices = $arr;
        if(!$lastServices){
            $lastServices[] = '{no data}';
        }
        if($count != null){
            if(!in_array('{no data}',$lastServices)){
                $lastServices = count($lastServices);
            }else{
                $lastServices = 0;
            }
        }
        return $lastServices;
    }

    static public function getLastOdometrValue($user_id){
        if(!isset($user_id) || empty($user_id)){
            throw new Exception ("error 746: ".__METHOD__);
        }
        $sql_last_ride_refill = "SELECT odometr FROM refill
                                  WHERE id_user = $user_id
                                  ORDER BY id DESC
                                  LIMIT 1;";
        $sql_last_ride_interval = "SELECT start_odo FROM service_intervals
                                  WHERE id_user = $user_id
                                  ORDER BY id DESC
                                  LIMIT 1;";

        $lastRideReff = WorkDB::getData($sql_last_ride_refill);
        if(is_array($lastRideReff)){
            $a = $lastRideReff[0]['odometr'];
        }else{
            $a = 0;
        }

        $lastRideInter = WorkDB::getData($sql_last_ride_interval);
        if(is_array($lastRideInter)){
            $b = $lastRideInter[0]['start_odo'];
        }else{
            $b = 0;
        }

        if($a>$b){
            $lastRide = $a;
        }elseif($a<$b){
            $lastRide = $b;
        }else{
            $lastRide = 0;
        }
        return $lastRide;
    }
}