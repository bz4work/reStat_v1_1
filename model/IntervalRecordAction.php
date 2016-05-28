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
                        WHERE si.id_user=".$id_user."AND id=".$id_record." ORDER BY si.id DESC;";
        }
        try {
            $data = WorkDB::getData($sql_get_rec);
            return $data;
        }catch (Exception $e){
            $logger = new Log();
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,$e->getMessage());

            $dataArray['err']['text'] = $err_txt = $e->getMessage();

            return $dataArray;
        }
    }

    public function getNameIntervals($id_user){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            Result::errorCreate(SystemConfig::getConfig('globalEr'),"Эта страница Вам не доступна вам, войдите.");
            Redirect::redirect();
        }
        if(!$id_user){
            throw new Exception ("Не передан id юзера или передан не верный id, не могу получить записи");
        }

        //получаем из базы все активные сервисы пользователя
        $sql_get_all_name = "SELECT id,name,status FROM name_intervals WHERE id_user=".$id_user." ORDER BY id DESC;";
        try {
            $dt = WorkDB::getData($sql_get_all_name);
            foreach ($dt as $item) {
                if($item['status'] == 0){
                    unset($item);
                }else{
                    $dataArray[] = $item;
                }
            }
            return $dataArray;
        //получаем из базы все активные сервисы пользователя

        }catch (Exception $e){
            $logger = new Log();
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,$e->getMessage());
            $err_txt = $e->getMessage();
            Result::errorCreate("globalError", $err_txt);

            $dataArray[0]['id'] = "error";
            $dataArray[0]['name'] = "error";
            return $dataArray;
        }
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
                    Result::successCreate('add_result','Данные добавлены в БД');
                    return true;
                }catch (Exception $e){
                    $err_text = $e->getMessage();
                    Result::errorCreate('add_error',"$err_text");
                    return false;
                }
            }
        }else{
            throw new Exception ("Не переданны данные для добавления в БД");
        }
    }

    public function deleteRecord($id){}


}