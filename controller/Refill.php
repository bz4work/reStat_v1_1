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

    public function index(){

        if(isset($_SESSION['id'])){
            $user_id = $_SESSION['id'];
        }elseif(empty($user_id = $this->getUserId())){
            throw new Exception ("Эта страница не доступна вам,войдите (elseif)");
        }

        $sql_getdata = "SELECT id,id_user,date,time,odometr,total_sum,total_liters,price_gas
                        FROM refill WHERE id_user=".$user_id." ORDER BY id DESC;";
        try {
            $this->dataArr = WorkDB::getData($sql_getdata);
        }catch (Exception $e){
            $logger = new Log();
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,$e->getMessage());
            $generateEmptyPage = new View();
            return $generateEmptyPage->render("empty");
        }

        $renderViewRefill = new View();
        return $renderViewRefill->render("refill", $this->dataArr);
    }

    /**
     * @throws Exception
     */
    public function generateFormAddRecord(){
        $formAddRecordView = new View();
        return $formAddRecordView->render("addRefills");
    }

    /**
     *
     */
    public function addRecord(){
        $dt = Request::clearData($_POST['date']);
        $tm = Request::clearData($_POST['time']);
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
            $_SESSION['add_result'] = "Данные добавлены в БД";
            return Redirect::redirect("index.php?refill=generateFormAddRecord");
        }catch (Exception $e){
            $_SESSION['add_error'] = $e->getMessage();
            Redirect::redirect("index.php?refill=generateFormAddRecord");
        }
    }

    public function editRecord(){
        //TO DO: сделать метод редактирования записи
    }

    public function deleteRecord(){
        //TO DO: сделать метод удвления записи
    }
}