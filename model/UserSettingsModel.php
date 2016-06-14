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

            $sql_get_value = "SELECT value FROM user_settings
                              WHERE id_user = $user_id AND setting_name = '$setting_name';";

            $res = WorkDB::getData($sql_get_value);

            if(is_array($res)){
                $value = $res[0]['value'];
            }else{
                $value = 0;
            }
        return $value;
    }

    static public function insertSetting($names, $inc_id=null){
        if(isset($_SESSION['id'])){
            $id = $_SESSION['id'];
        }

        if(isset($inc_id)){
            unset($id);
            $id = $inc_id;
        }

        if(isset($id)) {
            foreach ($names as $name => $value) {

                $sql = "INSERT INTO user_settings (id_user, `setting_name`, `value`)
                    VALUES ($id, '$name', '$value');";

                $res = WorkDB::insertData($sql);
                if ($res) {
                    $result[$name] = 'true';
                } else {
                    $result[$name] = 'false';
                }
            }
            return $result;
        }
        return false;
    }

    static public function updateSetting($names){
        $id = $_SESSION['id'];

        foreach ($names as $name=>$value) {

            $sql = "UPDATE user_settings SET `value` = '$value'
                        WHERE id_user = '$id' AND `setting_name` = '$name';";
            $res = WorkDB::insertData($sql);
            if($res){
                $result[$name] = 'true';
            }else{
                $result[$name] = 'false';
            }
        }
        return $result;
    }
}