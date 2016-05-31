<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 31.05.2016
 * Time: 19:55
 */
class Balance
{
    public function getBalance($id_user){
        $sql = "SELECT sumkm FROM total_km WHERE id_user=$id_user ORDER BY id DESC LIMIT 1;";
        try {
            $data = WorkDB::getData($sql);

            return $data;

        }catch (Exception $e){
            //$logger = new Log();
            //Log::writeToFile(__METHOD__,__FILE__,__LINE__,$e->getMessage());

            $data['err']['text'] = $e->getMessage();

            return $data;
        }
    }
}