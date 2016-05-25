<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 25.05.2016
 * Time: 18:20
 */
class RecordAction
{
    public function getRecord($id_user,$id_record = null){
        if(!$id_user){
          throw new Exception ("Не передан id юзера или передан не верный id, не могу получить записи");
        }

        if ($id_record == null){
            //выбрать все записи для юзера
            $sql_get_rec = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas
                        FROM refill WHERE id_user=".$id_user." ORDER BY id DESC;";
        }else{
            //выбрать запись которая соотвествует переданному $id
            $sql_get_rec = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas
                        FROM refill WHERE (id_user = ".$id_user." AND id = ".$id_record.") ORDER BY id DESC;";
        }
        try {
            $data = WorkDB::getData($sql_get_rec);
            return $data;
        }catch (Exception $e){
            $logger = new Log();
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,$e->getMessage());
            return $e->getMessage();
        }
    }

    public function createRecord($data){
        if(isset($data)){
            if (is_array($data)){
                $sql_add_rec = "INSERT INTO `refill`
                          (`id_user`,`date`,`time`,`odometr`,`total_sum`,`total_liters`,`price_gas`)
						  VALUES
						  ('{$data['id_user']}','{$data['dt']}','{$data['tm']}','{$data['odo']}',
						  '{$data['tot_sum']}','{$data['tot_lit']}','{$data['prc_gas']}')";

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

    public function deleteRecord($id){

    }

    /**
     * @param $id
     * @param $data
     * @return bool
     */
    public function updateRecord($id,$data){
        $sql_upd = "UPDATE refill SET
                                    date = '{$data['dt']}',
                                    time = '{$data['tm']}',
                                    odometr = '{$data['odo']}',
                                    total_sum = '{$data['tot_sum']}',
                                    total_liters = '{$data['tot_lit']}',
                                    price_gas = '{$data['prc_gas']}'
                 WHERE id = '$id'";
        try {
            WorkDB::insertData($sql_upd);
            return true;
        }catch (Exception $e){
            return $e->getMessage();
        }
    }


}