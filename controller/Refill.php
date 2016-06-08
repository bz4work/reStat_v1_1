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
    public $errorArr;

    /**
     * @throws Exception
     */
    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            Result::errorCreate("globalError","Эта страница Вам не доступна, войдите.");
            return Redirect::redirect("/page/aboutRefill/");
        }

        //$test = new Refill();
        //$test->getBalanceKm();

        $getRecord = new RefillRecordAction();
        $this->dataArr = $getRecord->getRecord($_SESSION['id']);

        $renderViewRefill = new View();
        return $renderViewRefill->render("refill", $this->dataArr);
    }

    public function generateFormAddRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
            $formAddRecordView = new View();
        if(isset($param['data'])){
            return $formAddRecordView->render($param['module'],$param['data']);
        }else{
            return $formAddRecordView->render($param['module']);
        }


    }

    /**
     * @param $param
     * @throws Exception
     */
    public function generateFormEditRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser");
        }
            $id_rec = $param['id'];
            $formAddRecordView = new View();
            $getData = new RefillRecordAction();
            //$data = $getData->getRecord($_SESSION['id'], $id_rec);
            $this->dataArr = $getData->getRecord($_SESSION['id'], $id_rec);
            //return $formAddRecordView->render($param['module'], $data);
            if (!empty($this->errorArr)){
                $this->dataArr['error'] = $this->errorArr;
            }
            return $formAddRecordView->render($param['module'], $this->dataArr);
    }

    /**
     * @throws Exception
     */
    public function addRecord()
    {
        $data = array(
            "odo" => Request::getPost('odo'),
            "tot_sum" => Request::getPost('total_sum'),
            "tot_lit" => Request::getPost('total_litres'),
            "prc_gas" => Request::getPost('price_gas'),
            "over" => Request::getPost('over'),
            "id_zap" => Request::getPost('id_zapravki'),
            "fuel_type" => Request::getPost('fuel_type')
        );

        foreach ($data as $key=>$item) {
            if(!$item) {
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Field $key not be empty";
                $data['err'] = 'err';

            }
        }
        if(array_key_exists('err',$data)){
            $param['module'] = 'addRefills';
            $param['data'] = $data;
            unset($data['err']);

            $msg = 'Зполните пустые поля';
            ErrorController::createErr($msg,"err");

            return $this->generateFormAddRecord($param);
        }

        $dt = Request::getPost('date');
        $tm = Request::getPost('time');
        $id_user = $_SESSION['id'];
        $id_zapravki = Request::getPost('id_zapravki');

        if (empty($dt)){
            $dt = date("Y-m-d",time());
            $data['dt'] = $dt;
        }
        if (empty($tm)){
            $tm = date("H:i",time());
            $data['tm'] = $tm;
        }
        if(empty($id_user)){
            throw new Exception ("Сессия не существует, войдите. Не могу добавить запись в БД.".__METHOD__);
        }
        if (empty($id_zapravki)){
            $id_zapravki = "null";
            $data['id_zapravki'] = $id_zapravki;
        }

        $data['id_user'] = $id_user;


        $add = new RefillRecordAction();
        $btn = Request::getPost("add_to_db");

        if (isset($btn)) {
            $res = $add->createRecord($data);
            if($res === true){
                Result::successCreate('add_result','Данные добавлены в БД');
                return Redirect::redirect("/refill/index/");
            }else{
                Result::errorCreate("globalError", $res);
                return Redirect::redirect("previous");
            }
        }
    }

    public function editRecord(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,"попытка доступа не авторизированного юзера к методу editRecord");
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
            $data = array(
                "dt" => Request::getPost('dt'),
                "tm" => Request::getPost('tm'),
                "odo" => Request::getPost('odo'),
                "tot_sum" => Request::getPost('tot_sum'),
                "tot_lit" => Request::getPost('tot_lit'),
                "prc_gas" => Request::getPost('prc_gas'),
                "fuel_type" => Request::getPost('fuel_type'),
                "id_zapravki" => Request::getPost('id_zapravki'),
            );
            $id_rec = Request::getPost("id");

            foreach ($data as $item) {
                if(!$item) {
                    $this->errorArr = "Не все поля заполнены. Проверьте!";
                    $param = ['module'=>'editRecord', 'id'=>"$id_rec"];
                    return $this->generateFormEditRecord($param);
                }
            }

            if (isset($id_rec) && !empty($id_rec)) {
                $update = new RefillRecordAction();
                $result = $update->updateRecord($id_rec, $data);

                if (!is_string($result)) {
                    Result::successCreate('globalResult', 'Данные обновлены!');
                    return Redirect::redirect("/refill/index");
                } else {
                    Result::errorCreate('globalError', 'Данные не обновлены! Причина: '.$result);
                    return Redirect::redirect("previous");
                }
            } else {
                throw new Exception ("id не существует или не передан");
            }
    }

    public function deleteRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            Log::writeToFile(__METHOD__,__FILE__,__LINE__,"попытка доступа не авторизированного юзера к методу editRecord");
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
        $id = $param['id'];
        $add = new RefillRecordAction();

            try {
                $add->deleteRecord($id);
                return Redirect::redirect("previous");
            } catch (Exception $e) {
                $err_text = $e->getMessage();
                return Result::errorCreate("globalError", $err_text);
            }
    }

    public function getBalanceKm(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            //Result::errorCreate("globalError","Войдите в систему под своим логином!");
            //return Redirect::redirect("previous");
        }else{
            $zapas = new BalanceModel();
            $value = $zapas->getBalance($_SESSION['id']);
            if (!$value){
                $_SESSION['balance'] = 'нет данных';
            }
            if(array_key_exists('err',$value)){
                $_SESSION['balance'] = 'нет данных';
            }else{
                $_SESSION['balance'] = $value[0]['sumkm'];
            }

        }

        //return Redirect::redirect("previous");
    }
}