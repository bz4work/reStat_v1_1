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

    /**
     * @throws Exception
     */
    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            /*$id = $this->getUserId();
            if(!isset($id)){
                $this->setUserId($_SESSION['id']);
            }*/
            Result::errorCreate("globalError","Эта страница Вам не доступна, войдите.");
            return Redirect::redirect();
        }

        $getRecord = new RefillRecordAction();
        $this->dataArr = $getRecord->getRecord($_SESSION['id']);

        $renderViewRefill = new View();
        return $renderViewRefill->render("refill", $this->dataArr);
    }

    public function generateFormAddRecord($param){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
            $formAddRecordView = new View();
            return $formAddRecordView->render($param['module']);
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("index.php?".SystemConfig::getConfig('login')."=checkUser");
        }

    }

    /**
     * @param $param
     * @throws Exception
     */
    public function generateFormEditRecord($param){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])) {
            $id_rec = $param['id'];

            $formAddRecordView = new View();

            $getData = new RefillRecordAction();
            $data = $getData->getRecord($_SESSION['id'], $id_rec);

            return $formAddRecordView->render($param['module'], $data);
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("index.php?".SystemConfig::getConfig('login')."=checkUser");
        }
    }

    /**
     * @throws Exception
     */
    public function addRecord()
    {
        $data = array(
            "dt" => Request::getPost('date'),
            "tm" => Request::getPost('time'),
            "id_user" => $_SESSION['id'],
            "odo" => Request::getPost('odo'),
            "tot_sum" => Request::getPost('total_sum'),
            "tot_lit" => Request::getPost('total_litres'),
            "prc_gas" => Request::getPost('price_gas'),
            //"id_zapravki" => Request::getPost('id_zapravki'),
            "over" => Request::getPost('over')
        );

        $add = new RefillRecordAction();
        $btn = Request::getPost("add_to_db");
        if (isset($btn)) {

            try {
                $add->createRecord($data);
            } catch (Exception $e) {
                $err_text = $e->getMessage();
                Result::errorCreate("globalError", $err_text);
            }
        }

        return Redirect::redirect();
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

                $add = new RefillRecordAction();

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

    public function deleteRecord($param){
        $id = $param['id'];

        $add = new RefillRecordAction();


        if (isset($_SESSION['user'])) {

            try {
                $add->deleteRecord($id);
            } catch (Exception $e) {
                $err_text = $e->getMessage();
                Result::errorCreate("globalError", $err_text);
            }
        }else{
            Result::errorCreate("globalError","Вы не вошли. Войдите.");
            Redirect::redirect();
        }
        Redirect::redirect();

    }

    public function getLiters(){
        $ovr = Request::getPost("over");
        $sum = Request::getPost("total_sum");
        $prc = Request::getPost("price_gas");
        if (isset($ovr,$sum,$prc)){
            $result = $sum/$prc;
            return Request::setPost("total_litres",$result);
        }

    }
}