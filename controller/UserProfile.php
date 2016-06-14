<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 23:16
 */
class UserProfile
{
    static public $_data = array();

    static public function initPanel(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            return self::$_data = null;
        }
        $id = $_SESSION['id'];

        $data = [ "name" => $_SESSION['user'],
                  "reserve" => RefillRecordAction::getRideReserve($id),
                  "nextRefill" => "{need_calc}",
                  "lastRefill" => UserProfileModel::getLastDate($id),
                  "lastAmountRefill" => UserProfileModel::getLastAmount($id),
                  "lastAverageRate" => "{need_calc}",
                  "ThreeNextServices" => "{a} {b} {c}"];
        return self::$_data = $data;
    }

    static public function getUserInfo(){
        self::initPanel();
        return self::$_data;
    }

    public function settingsPage($result=array()){
        $id = $_SESSION['id'];
        $data = array();

        /*расход топлива
        основной вид топлива
        используемые виды топлива
        активные сервисы
        сменить пароль
        сменить e-mail*/
        $data['fuel_economy'] = UserSettingsModel::getValueSetting("fuel_economy");
        $data['main_fuel_type'] = UserSettingsModel::getValueSetting("main_fuel_type");

        /*$name = new IntervalRecordAction();
        $data['activeServiceName'] = $name->getNameIntervals($id);*/

        if(count($result) > 0){
            $data['stat'] = $result;
        }

        $settingsPage = new View();
        return $settingsPage->render('userSettings',$data);
    }

    public function updateSettings()
    {
        $data = [
            'fuel_economy' => (int)Request::getPost('fuel_economy'),
            'main_fuel_type' => (string)Request::getPost('main_fuel_type')
        ];
        $current = [
            'fuel_economy' => (int)UserSettingsModel::getValueSetting("fuel_economy"),
            'main_fuel_type' => (string)UserSettingsModel::getValueSetting("main_fuel_type")
        ];
        //сравниваем массивы и если есть значения которые отличаются -
        //пишем их в БД
        $result = UserSettingsModel::updateSetting($data);

        foreach ($result as $name=>$stat) {
            if ($stat == 'true'){
                $saveRes[$name] = "bg-success";
                $saveRes[$name.'_msg'] = "done!";
            }else{
                $saveRes[$name] = "bg-danger";
                $saveRes[$name.'_msg'] = "error!";
            }
        }
        return $this->settingsPage($saveRes);
    }

    /**
     * default setting, when a user creates
     * @return array
     */
    static public function allowSetting(){
        return $arrSet = [
                'fuel_economy'=>0,
                'main_fuel_type'=>''
        ];
    }
}