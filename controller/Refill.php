<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 19.05.2016
 * Time: 9:49
 */
class Refill extends BaseController
{
    public $dataArr;

    /**
     * @throws Exception
     */
    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            return Redirect::redirect("/page/aboutRefill/");
        }

        $all_record = new RefillRecordAction();
        $this->dataArr = $all_record->getRecord($_SESSION['id']);

        $view = new View();
        return $view->render("refill", $this->dataArr);
    }

    public function generateFormAddRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
        $view = new View();
        if(isset($param['data'])){
            return $view->render($param['module'],$param['data']);
        }else{
            return $view->render($param['module']);
        }
    }

    /**
     * @param $param
     * @throws Exception
     */
    public function generateFormEditRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser");
        }
            $view = new View();

            if(isset($param['data'])){
                return $view->render($param['module'], $param['data']);
            }else{
                $id_record = $param['id'];
                $record = new RefillRecordAction();
                $this->dataArr = $record->getRecord($_SESSION['id'], $id_record);
                return $view->render($param['module'], $this->dataArr);
            }
    }

    /**
     * @throws Exception
     */
    public function addRecord(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }

        $data = array(
            "odo" => Request::getPost('odo'),
            "tot_sum" => Request::getPost('total_sum'),
            "prc_gas" => Request::getPost('price_gas'),
            "over" => Request::getPost('over'),
            //"id_zapravki" => Request::getPost('id_zapravki'),
            "fuel_type" => Request::getPost('fuel_type')
        );

        $data = $this->checkEmptyFiled($data);
        if(array_key_exists('err',$data)){
            $param['module'] = 'addRefills';
            $param['data'] = $data;
            unset($data['err']);
            ErrorController::createErr('Зполните пустые поля');
            return $this->generateFormAddRecord($param);
        }

        $dt = Request::getPost('date');
        $tm = Request::getPost('time');
        //$id_user = $_SESSION['id'];
        $id_zapravki = Request::getPost('id_zapravki');
        $tot_lit = Request::getPost('total_litres');

        if (empty($dt)){
            $dt = date("Y-m-d",time());
            $data['dt'] = $dt;
        }
        if (empty($tm)){
            $tm = date("H:i",time());
            $data['tm'] = $tm;
        }
        if (empty($id_zapravki)){
            $id_zapravki = "empty";
            $data['id_zapravki'] = $id_zapravki;
        }
        if(empty($tot_lit)){
            $tot_lit = $data['tot_sum']/$data['prc_gas'];
            $data['tot_lit'] = round($tot_lit,2);
        }
        $data['id_user'] = $_SESSION['id'];
        $data['id_zapravki'] = $id_zapravki;

        $refillModel = new RefillRecordAction();

        $fuel_economy = UserSettingsModel::getValueSetting('fuel_economy',$data['id_user']);
        $mainFuelType = UserSettingsModel::getValueSetting('main_fuel_type',$data['id_user']);

        if ($fuel_economy == 0 or $mainFuelType == ''){
            ErrorController::createErr("Сначала нужно заполнить настройки");
            return Redirect::redirect("/userProfile/settingsPage/");
            exit();
        }

        if($mainFuelType == $data['fuel_type']){
            if ($data['over'] == 'no'){
                $current['reserve'] = RefillRecordAction::getRideReserve($data['id_user']);
                $current['reserve'] += round(($data['tot_lit']/$fuel_economy)*100,0);
                $current['over'] = 'no';
            }else{
                $current['reserve'] = round(($data['tot_lit']/$fuel_economy)*100,0);
                $current['over'] = 'yes';
            }

            $refillModel->setRideReserve($current);
        }

        $btn = Request::getPost("add_to_db");
        if (isset($btn)) {
            $res = $refillModel->createRecord($data);
            if(is_string($res)){
                ErrorController::createErr($res);
                return Redirect::redirect("previous");
            }else{
                ErrorController::destroyMsg(array('name' => 'error'));
                ErrorController::createSuccess('Данные добавлены в БД');
                return Redirect::redirect("/refill/index/");
            }
        }
    }

    public function editRecord(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
            $data = array(
                "date" => Request::getPost('date'),
                "time" => Request::getPost('time'),
                "odometr" => Request::getPost('odometr'),
                "total_sum" => Request::getPost('total_sum'),
                "total_liters" => Request::getPost('total_liters'),
                "price_gas" => Request::getPost('price_gas'),
                "fuel_type" => Request::getPost('fuel_type'),
            );
            $id_rec = Request::getPost("id");
            $data = $this->checkEmptyFiled($data);
            $data['id_zapravki'] = Request::getPost('id_zapravki');
            $data['id'] = $id_rec;

            if(array_key_exists('err',$data)){
                $param['module'] = 'editRecord';
                $param['data'] = $data;
                unset($data['err']);
                ErrorController::createErr('Зполните пустые поля');
                return $this->generateFormEditRecord($param);
            }

            if (isset($id_rec) && !empty($id_rec)) {
                $update = new RefillRecordAction();
                $result = $update->updateRecord($id_rec, $data);
                if (is_string($result)) {
                    ErrorController::createErr('Данные не обновлены! Причина: '.$result);
                    return Redirect::redirect("previous");
                } else {
                    ErrorController::createSuccess('Данные обновлены!');
                    ErrorController::destroyMsg(array('name' => 'error'));
                    return Redirect::redirect("/refill/index");
                }
            } else {
                ErrorController::createErr("id не существует или не передан");
                return Redirect::redirect("previous");
            }
    }

    public function deleteRecord($param){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            ErrorController::createErr("Войдите в систему под своим логином!");
            return Redirect::redirect("/login/checkUser/");
        }
        $id = $param['id'];
        $del = new RefillRecordAction();

            try {
                $del->deleteRecord($id);
                ErrorController::createSuccess("Запись №$id - удалена!");
                return Redirect::redirect("previous");
            } catch (Exception $e) {
                //$err_text = $e->getMessage();
                ErrorController::createErr($e->getMessage());
                return Redirect::redirect("previous");
            }
    }
}