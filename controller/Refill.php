<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 19.05.2016
 * Time: 9:49
 */
class Refill
{
    public $dataArr;

    public function index($user_id){

        $sql_getdata = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas
                        FROM refill WHERE id_user=$user_id ORDER BY id DESC;";

        $this->dataArr = WorkDB::getData($sql_getdata);

        $renderViewRefill = new View();

        return $renderViewRefill->render("refill", $this->dataArr);
    }

    public function addRecord(){
        //TO DO: сделать метод добавления данных в базу
       Redirect::redirect("index.php?page=main");
    }

    public function editRecord(){
        //TO DO: сделать метод редактирования записи
    }

    public function deleteRecord(){
        //TO DO: сделать метод удвления записи
    }


}