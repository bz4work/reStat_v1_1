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
    /*public $user_id;

    public function setUserId($user_id){
        $this->user_id = $user_id;
    }

    public function getUserId(){
        return $this->user_id;
    }*/

    /**
     * @throws Exception
     */
    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            Result::errorCreate("globalError","Эта страница Вам не доступна, войдите.");
            return Redirect::redirect(Config::getConfig("logCheck"));
        }

        //$zapas_value = new Refill();
        //$zapas_value->getBalanceKm();

        $getRecord = new RefillRecordAction();
        $this->dataArr = $getRecord->getRecord($_SESSION['id']);

        $url = array("refFormAdd"  => Config::getConfig('refFormAdd'),
                     "refDelRec"   => Config::getConfig('refDelRec'),
                     "refFormEdit" => Config::getConfig('refFormEdit'),
        );

        $renderViewRefill = new View();
        return $renderViewRefill->render("refill", $this->dataArr,$url);
    }

    public function generateFormAddRecord($param){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){
            $formAddRecordView = new View();
            $url = [
                    'refAddRec'=>Config::getConfig('refAddRec'),
                    'refIndex' =>Config::getConfig('refIndex')
            ];
            return $formAddRecordView->render($param['module'],$d=[],$url);
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect(Config::getConfig("logCheck"));
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
            Redirect::redirect(Config::getConfig("logCheck"));
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
        foreach ($data as $item) {
            if(!$item){
                Result::errorCreate("add_error", "Не все поля заполнены. Проверьте!");
                return Redirect::redirect("previous");
            }

        }

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

        return Redirect::redirect("previous");
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
                    Result::errorCreate('globalError', 'Данные не обновлены! Причина: '.$result);
                }

                //return Redirect::redirect("/login/checkUser/");
                $redirect = new Redirect();
                return $redirect->refIndexLoad();
            } else {
                throw new Exception ("id не существует или не передан");
            }
        }else{
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,"попытка доступа не авторизированного юзера к методу editRecord");
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect(Config::getConfig("logCheck"));
        }
    }

    public function deleteRecord($param){
        $id = $param['id'];
        $add = new RefillRecordAction();

        if (isset($_SESSION['user'])) {

            try {
                $add->deleteRecord($id);
                Redirect::redirect("previous");
            } catch (Exception $e) {
                $err_text = $e->getMessage();
                Result::errorCreate("globalError", $err_text);
            }
        }else{
            Result::errorCreate("globalError","Вы не вошли. Войдите.");
            Redirect::redirect("previous");
        }

    }

    public function getBalanceKm(){
        $zapas = new Balance();
        $value = $zapas->getBalance($_SESSION['id']);
        $_SESSION['balance'] = $value[0]['sumkm'];
        return Redirect::redirect("previous");
    }
}