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
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
            $formAddRecordView = new View();
            return $formAddRecordView->render("addRefills");
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("index.php?".SystemConfig::getConfig('login')."=checkUser");
        }

    }

    /**
     * @param $id
     * @throws Exception
     */
    public function generateFormEditRecord($id){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $id_rec = $id['id'];

            $formAddRecordView = new View();

            $getData = new RecordAction();
            $dt = $getData->getRecord($_SESSION['id'], $id_rec);

            return $formAddRecordView->render("editRecord", $dt);
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("index.php?".SystemConfig::getConfig('login')."=checkUser");
        }
    }

    /**
     * @throws Exception
     */
    public function addRecord(){
        $data = array(
            "dt" => Request::getPost('date'),
            "tm" => Request::getPost('time'),
            "id_user" => $_SESSION['id'],
            "odo" => Request::getPost('odo'),
            "tot_sum" => Request::getPost('total_sum'),
            "tot_lit" => Request::getPost('total_litres'),
            "prc_gas" => Request::getPost('price_gas'),
            //"id_zapravki" => Request::getPost('id_zapravki'),
            //"over" => Request::getPost('over')
        );

        $add = new RecordAction();

        try{
            $add->createRecord($data);
        }catch(Exception $e){
            $err_text = $e->getMessage();
            Result::errorCreate("globalError",$err_text);
        }

        return Redirect::redirect("index.php?refill=generateFormAddRecord");
    }

    public function editRecord(){
        if(isset($_SESSION['user']) || !empty($_SESSION['user'])) {
            $data = array(
                "dt" => Request::getPost('dt'),
                "tm" => Request::getPost('tm'),
                "odo" => Request::getPost('odo'),
                "tot_sum" => Request::getPost('tot_sum'),
                "tot_lit" => Request::getPost('tot_lit'),
                "prc_gas" => Request::getPost('prc_gas'),
                //"id_zapravki" => Request::getPost('id_zapravki'),
                //"over" => Request::getPost('over')
            );

            $id_rec = Request::getPost("id");

            if (isset($id_rec) && !empty($id_rec)) {

                $add = new RecordAction();

                $result = $add->updateRecord($id_rec, $data);

                if (!is_string($result)) {
                    Result::successCreate('globalResult', 'Данные обновлены!');
                } else {
                    Result::errorCreate('globalError', 'Данные не обновлены! Причина: ' . $result);
                }

                return Redirect::redirect("index.php?refill=index");

            } else {
                throw new Exception ("id не существует или не передан");
            }
        }else{
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,"попытка доступа не авторизированного юзера к методу editRecord");
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("index.php?login=checkUser");
        }
    }

    public function deleteRecord(){
        //TO DO: сделать метод удвления записи
    }
}