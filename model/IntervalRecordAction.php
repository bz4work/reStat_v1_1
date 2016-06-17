<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 26.05.2016
 * Time: 22:36
 */
class IntervalRecordAction extends RefillRecordAction{

    public function getRecord($id_user,$id_record = null){
        if(!$id_user){
            throw new Exception ("Не передан id юзера или передан не верный id, не могу получить записи");
        }

        if ($id_record == null){
            //выбрать все записи для юзера
            $sql_get_rec = "SELECT si.id,
                               si.id_user,
                               date_add,
                               time_add,
                               ni.name,
                               start_odo,
                               `interval`,
                               finish_odo,
                               start_date,
                               interval_days,
                               finish_date,
                               comment,
                               notify
                        FROM service_intervals AS si LEFT JOIN name_intervals AS ni
                        ON si.name = ni.id
                        WHERE si.id_user=".$id_user." ORDER BY si.id DESC;";
        }else{
            //выбрать запись которая соотвествует переданному $id
            $sql_get_rec = "SELECT si.id,
                               si.id_user,
                               date_add,
                               time_add,
                               ni.name,
                               start_odo,
                               `interval`,
                               finish_odo,
                               start_date,
                               interval_days,
                               finish_date,
                               comment,
                               notify
                        FROM service_intervals AS si LEFT JOIN name_intervals AS ni
                        ON si.name = ni.id
                        WHERE si.id_user=".$id_user." AND si.id=".$id_record." ORDER BY si.id DESC;";
        }

        $data = WorkDB::getData($sql_get_rec);
        if (is_array($data)){
            return $data;
        }else{
            //инициализация переменной для правильного отображения в шаблоне
            $dataArray['err']['text'] = " ";
            return $dataArray;
        }
    }

    public function getNameIntervals($id_user){
        //получаем из базы все активные сервисы пользователя
        $sql_get_all_name = "SELECT id,name,status FROM name_intervals WHERE id_user=".$id_user." ORDER BY id DESC;";

        $dt = WorkDB::getData($sql_get_all_name);
        if(is_array($dt)) {
            foreach ($dt as $item) {
                if ($item['status'] == 0) {
                    unset($item);
                } else {
                    $dataArray[] = $item;
                }
            }
        }
        if (!isset($dataArray)) {
            $dataArray[0]['id'] = "error";
            $dataArray[0]['name'] = "нет активных сервисов";
        }
        return $dataArray;
    }

    public function createRecord($data){
        if(isset($data)){
            if (is_array($data)){
                if(!empty($data['start_odo'])){
                    //если НЕ пустое значение "начала интервала по одометру"
                    //будет работать этот запрос

                    $sql_add_rec = "INSERT INTO `service_intervals`
                          (`id_user`,`date_add`,`time_add`,`name`,`start_odo`,`interval`,
                          `finish_odo`,`comment`,`notify`)
						  VALUES
						  ('{$data['id_user']}',
						  '{$data['date_add']}',
						  '{$data['time_add']}',
						  '{$data['name_interval']}',
						  '{$data['start_odo']}',
						  '{$data['interval']}',
						  '{$data['finish_odo']}',
						  '{$data['comment']}',
						  '{$data['notify']}'
						  )";
                }else{
                    //если ПУСТОЕ значение "начала интервала по одометру"
                    //будет работать этот запрос
                    $sql_add_rec = "INSERT INTO `service_intervals`
                          (`id_user`,`date_add`,`time_add`,`name`,`start_date`,`interval_days`,
                          `finish_date`,`comment`,`notify`)
						  VALUES
						  ('{$data['id_user']}',
						   '{$data['date_add']}',
						   '{$data['time_add']}',
						   '{$data['name_interval']}',
						   '{$data['start_date']}',
						   '{$data['interval_days']}',
						   '{$data['finish_date']}',
						   '{$data['comment']}',
						   '{$data['notify']}'
						   )";
                }

                try {
                    WorkDB::insertData($sql_add_rec);
                    return true;
                }catch (Exception $e){
                    $err_text = $e->getMessage();
                    return false;
                }
            }
        }else{
            throw new Exception ("Не переданны данные для добавления в БД");
        }
    }

    public function deleteRecord($id){
        if(!isset($id) || empty($id)){
            throw new Exception ("Не передан параметр для удаление или передан пустой.");
        }
        $sql_del = "DELETE FROM service_intervals WHERE `id` = $id;";

        try {
            WorkDB::insertData($sql_del);
            return true;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }

    public function updateRecord($id,$data){
        $sql_upd = "UPDATE service_intervals SET
                                    date = '{$data['dt']}',
                                    time = '{$data['tm']}',
                                    odometr = '{$data['odo']}',
                                    total_sum = '{$data['tot_sum']}',
                                    total_liters = '{$data['tot_lit']}',
                                    price_gas = '{$data['prc_gas']}',
                                    fuel_type = '{$data['fuel_type']}',
                                    id_zapravki = '{$data['id_zapravki']}'
                 WHERE id = '$id'";
        try {
            WorkDB::insertData($sql_upd);
            return true;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }
}