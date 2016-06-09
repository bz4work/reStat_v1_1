<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 09.06.2016
 * Time: 15:30
 */
class UserSettingsModel
{
    static public function getValueSetting($setting_name){
        $user_id = $_SESSION['id'];

        $sql = "SELECT id FROM settings_name WHERE name='$setting_name';";

        if ($data = WorkDB::getData($sql)) {
            $id_setting = $data[0]['id'];

            $sql_get_value = "SELECT value FROM user_settings
                              WHERE id_user = '$user_id' AND id_setting = '$id_setting';";

            $res = WorkDB::getData($sql_get_value);
            if(is_array($res)){
                $value = $res[0]['value'];
                return $value;
            }else{
                return 0;
            }
        } else {
            return "Не удалось выполнить запрос в методе. В БД нету настроек юзеров.";
        }
    }
}