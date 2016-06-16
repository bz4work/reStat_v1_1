<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 15.06.2016
 * Time: 18:52
 */
class UserPanel
{
    static public $_data = array();

    /**
     * инициализация и сбор данных для панели юзера
     * @return array|null
     */
    static public function initPanel(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            return self::$_data = null;
        }
        $id = $_SESSION['id'];
        $data = [ "name" => $_SESSION['user'],
            "reserve" => RefillRecordAction::getRideReserve($id),
            "nextRefill" => UserPanelModel::nextRefill($id),
            "lastRefill" => UserPanelModel::getLastDate($id),
            "lastAmountRefill" => UserPanelModel::getLastAmount($id),
            "lastAverageRate" => "{need_calc}",
            "ThreeNextServices" => "{a} {b} {c}"];
        return self::$_data = $data;
    }

    static public function getUserPanelData(){
        self::initPanel();
        return self::$_data;
    }
}