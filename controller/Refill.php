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
    public $user_id;

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getUserId(){
        return $this->user_id;
    }

    public function index($decorate=array()){

        if(count($decorate) != 0){
            foreach ($decorate as $key=>$item) {
                $this->dataArr[$key] = $item;
            }
        }

        if(isset($_SESSION['id'])){

            $user_id = $_SESSION['id'];

        }elseif(empty($user_id = $this->getUserId())){
            throw new Exception ("Эта страница не доступна вам,войдите (elseif)");
        }

        $sql_getdata = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas
                        FROM refill WHERE id_user=".$user_id." ORDER BY id DESC;";

        $this->dataArr['dataDB'] = WorkDB::getData($sql_getdata);

        $renderViewRefill = new View();

        return $renderViewRefill->render("refill", $this->dataArr);
    }

    public function generateFormAddRecord(){
        $formAddRecordView = new View();

        $arrDecoreHtml['decorate']['addRec'] = $formAddRecordView->renderFormAddRecord();

        return $this->index($arrDecoreHtml);
    }

    public function addRecord(){
        //TO DO: сделать метод добавления записи в БД
        $dt = time();
        $tm = time();

        $id_user = $_SESSION['id'];

        $odo = Request::clearData($_POST['odo']);
        $tot_sum = Request::clearData($_POST['total_sum'], "float");
        $tot_lit = Request::clearData($_POST['total_litres'], "float");
        $prc_gas = Request::clearData($_POST['price_gas'], "float");

        //$id_zapravki = Request::clearData($_POST['id_zapravki']);
        //$over = Request::clearData($_POST['over'], "string");

        $sql_insert_record = "INSERT INTO `refill`
                          (`id_user`,`date`,`time`,`odometr`,`total_sum`,`total_liters`,`price_gas`)
						  VALUES
						  ('$id_user','$dt','$tm','$odo','$tot_sum','$tot_lit','$prc_gas')";

        try {
            WorkDB::insertData($sql_insert_record);
            $_SESSION['result'] = "Данные добавлены в БД";
            Redirect::redirect("index.php?refill=index");
        }catch (Exception $e){
            $_SESSION['error'] = $e->getMessage();
            Redirect::redirect("index.php?refill=index");
        }


    }

    public function editRecord(){
        //TO DO: сделать метод редактирования записи
    }

    public function deleteRecord(){
        //TO DO: сделать метод удвления записи
    }


}