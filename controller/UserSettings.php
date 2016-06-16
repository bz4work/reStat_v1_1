<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 23:16
 */
class UserSettings
{
    public function settingsPage(){
        $id = $_SESSION['id'];
        /*расход топлива
        основной вид топлива
        используемые виды топлива
        активные сервисы
        сменить пароль
        сменить e-mail*/
        $data['fuel_economy'] = UserSettingsModel::getValueSetting("fuel_economy",$id);
        $data['main_fuel_type'] = UserSettingsModel::getValueSetting("main_fuel_type",$id);
        $data['volume_tank'] = UserSettingsModel::getValueSetting("volume_tank",$id);
        $data['mileage_per_day'] = UserSettingsModel::getValueSetting("mileage_per_day",$id);

        $settingsPage = new View();
        return $settingsPage->render('userSettings',$data);
    }

    //
    //Включена ветка user_block
    //не забыть переключить и слить
    //

    public function updateSettings()
    {
        $data = [
            'fuel_economy' => (string)Request::getPost('fuel_economy'),
            'main_fuel_type' => (string)Request::getPost('main_fuel_type'),
            'volume_tank' => (string)Request::getPost('volume_tank'),
            'mileage_per_day' => (string)Request::getPost('mileage_per_day')
        ];
        foreach ($data as $k=>$inputValue) {
            if(empty($inputValue)){
                unset($data[$k]);
            }
        }
        if(count($data)>0){
            UserSettingsModel::updateSetting($data);
        }
        return Redirect::redirect('/userSettings/settingsPage/');
    }

    /**
     * default setting, when a user creates
     * @return array
     */
    static public function allowSetting(){
        return $arrSet = [
                'fuel_economy'=>0,
                'main_fuel_type'=>'',
                'volume_tank'=>30,
                'mileage_per_day'=>50,
                'limit_interval_notify_km'=>300,
                'limit_interval_notify_day'=>3
        ];
    }
}