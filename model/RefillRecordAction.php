<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 25.05.2016
 * Time: 18:20
 */
class RefillRecordAction
{
    public function getRecord($id_user,$id_record = null){
        if(!$id_user){
            ErrorController::createErr("Не передан id юзера или передан не верный id, не могу получить записи");
            return Redirect::redirect("/page/main/");
        }

        if ($id_record == null){
            //выбрать все записи для юзера
            $sql_get_rec = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas,fuel_type,id_zapravki
                            FROM refill
                            WHERE id_user=".$id_user."
                            ORDER BY id DESC;";
        }else{
            //выбрать запись которая соотвествует переданному $id
            $sql_get_rec = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas,fuel_type,id_zapravki
                            FROM refill
                            WHERE (id_user = ".$id_user."
                            AND id = ".$id_record.")
                            ORDER BY id DESC;";
        }
            $data = WorkDB::getData($sql_get_rec);
            if(is_array($data)){
                if (isset($id_record)) {
                    //если выбираем данные одной записи -
                    //вернуть обычный массив (не вложенный)
                    return $data[0];
                }else{
                    $data = Refill::numeratingArr($data);
                    return $data;
                }
            }else{
                $data['err']['text'] = ' ';
                return $data;
            }
    }

    public function createRecord($data){
        if(isset($data)){
            if (is_array($data)){
                $sql_add_rec = "INSERT INTO refill
                          (id_user,date,time,odometr,total_sum,total_liters,price_gas,
                          fuel_type,id_zapravki)
						  VALUES
						  ({$data['id_user']},'{$data['dt']}','{$data['tm']}',{$data['odo']},
						  {$data['tot_sum']},{$data['tot_lit']},{$data['prc_gas']},
						  '{$data['fuel_type']}','{$data['id_zapravki']}')";

                if (WorkDB::insertData($sql_add_rec)) {
                    return true;
                } else {
                    return "Не удалось выполнить запрос в методе:" . __METHOD__ .
                        ". Проверить правильность запроса.";
                }
            }else{
                return "Передан не массив.";
            }
        }else{
            return "Не переданны данные для добавления в БД";
        }
    }

    public function deleteRecord($id){
        if (!isset($id) || empty($id)) {
            throw new Exception ("Не передан параметр для удаление или передан пустой.");
        }
        $sql_del = "DELETE FROM refill WHERE `id` = $id;";

        if (WorkDB::insertData($sql_del)) {
            return true;
        } else {
            throw new Exception ("Не удалось выполнить запрос в методе:" . __METHOD__ .
                ". Проверить правильность запроса.");
        }

    }

    public function updateRecord($id,$data){
        $sql_upd = "UPDATE refill SET
                                    date = '{$data['date']}',
                                    time = '{$data['time']}',
                                    odometr = '{$data['odometr']}',
                                    total_sum = '{$data['total_sum']}',
                                    total_liters = '{$data['total_liters']}',
                                    price_gas = '{$data['price_gas']}',
                                    fuel_type = '{$data['fuel_type']}',
                                    id_zapravki = '{$data['id_zapravki']}'
                 WHERE id = '$id'";

        if(WorkDB::insertData($sql_upd)){
            return true;
        }else{
            return 'Не удалось выполнить запрос к БД.';
        }
    }

    public function setRideReserve ($currentReserve){
        $user_id = $_SESSION['id'];
        if(is_array($currentReserve)){
            $currentReserve = $currentReserve['reserve'];
        }

        $sql = "INSERT INTO total_km (id_user,sumkm) VALUE ($user_id,$currentReserve);";
        if($data = WorkDB::insertData($sql)){
            return true;
        }else{
            return false;
        }
    }

    static public function getRideReserve ($user_id){
        $sql = "SELECT sumkm FROM total_km WHERE id_user = $user_id ORDER BY id DESC LIMIT 1;";

        $data = WorkDB::getData($sql);
        if(is_array($data)){
            return $data[0]['sumkm'];
        }else{
            return 0;
        }

    }
}