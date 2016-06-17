<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 26.05.2016
 * Time: 21:25
 */
class ServiceIntervals extends Refill{
    public $intervalsData;

    public function index(){
        //отображение стартовой таблицы
        if(!isset($_SESSION['id'])){
            return Redirect::redirect('/page/aboutIntervals');
        }

        $record = new IntervalRecordAction();
        $this->intervalsData = $record->getRecord($_SESSION['id']);

        $view = new View();
        return $view->render("intervals", $this->intervalsData);
    }

    public function addRecord(){
        //добавить новую запись в service_intervals
        //вызывать метод модели
        $data = array(
            "id_user" => $_SESSION['id'],
            "date_add" => Request::getPost('date_add'),
            "time_add" => Request::getPost('time_add'),
            "name_interval" => Request::getPost('name_interval'),
            "start_odo" => Request::getPost('start_odo'),
            "interval" => Request::getPost('interval'),
            //"finish_odo" => Request::getPost('finish_odo'),
            "start_date" => Request::getPost('start_date'),
            "interval_days" => Request::getPost('interval_days'),
            //"finish_date" => Request::getPost('finish_date'),
            "comment" => Request::getPost('comment'),
            "notify" => Request::getPost('notify'),
        );

        //заполняем автоматом 2 первых поля дата и время
        if(!$data['date_add']){
            $data['date_add'] = date("Y-m-d",time());
        }
        if(!$data['time_add']){
            $data['time_add'] = date("H:i",time());
        }

        //проверяем выбран ли сервис
        if(!$data['name_interval'] || $data['name_interval'] == "id_error"){
            Result::errorCreate("add_error", "Выберите сервис");
            return Redirect::redirect("previous");
        }

        //считаем дату кончания интервала если указана начальная дата
        if(!empty($data['start_date'])) {
            $date_parts = explode('-', $data['start_date']);
            $year = array_shift($date_parts);
            $month = array_shift($date_parts);
            $day = array_shift($date_parts);
            $day += $data['interval_days'];
            $data['finish_date'] = date("Y-m-d", mktime(0, 0, 0, $month, $day, $year));
        }else{
            $data['start_date'] = null;
            $data['finish_date'] = null;
        }

        //получаем id выбранного сервиса
        $id_intervals = explode("_",$data['name_interval']);
        $data['name_interval'] = $id_intervals[1];

        //считаем конец интервала в КМ если передано начальное значение
        if(isset($data['start_odo'])) {
            $data['finish_odo'] = $data['start_odo'] + $data['interval'];
        }else{
            $data['start_odo'] = null;
            $data['finish_odo'] = null;
        }

        $add = new IntervalRecordAction();
        try{
            $add->createRecord($data);
        }catch(Exception $e){
            $err_text = $e->getMessage();
            ErrorController::createErr($err_text);
        }
        return Redirect::redirect("/serviceIntervals/index/");
    }

    public function generateFormAddRecord($param){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

            $names = new IntervalRecordAction();
            $this->intervalsData = $names->getNameIntervals($_SESSION['id']);
            $this->intervalsData['date'] = date('Y-m-d',time());
            $this->intervalsData['time'] = date('H:i',time());

            $formAddRecordView = new View();
            return $formAddRecordView->render($param['module'],$this->intervalsData);
        }else{
            ErrorController::createErr('Войдите в систему под своим логином!');
            Redirect::redirect("/login/checkUser/");
        }

    }

    public function generateFormEditRecord($param){
        if(!isset($_SESSION['user']) && empty($_SESSION['user'])) {
            ErrorController::createErr('Войдите в систему под своим логином!');
            Redirect::redirect("/login/checkUser/");
        }
            $id_rec = $param['id'];

            $form = new View();
            $getData = new IntervalRecordAction();
            $data = $getData->getRecord($_SESSION['id'], $id_rec);
            foreach ($data as &$record) {
                //в каждом вложенном массиве record
                // лежат данные по одному интервалу
                foreach ($record as $k=>$item) {
                    //удаляем пустые ячейки
                    if ($item == null){
                        unset($record[$k]);
                    }
                }
            }
            //выбираем все включенные сервисы
            $data['services'] = $getData->getNameIntervals($_SESSION['id']);
            return $form->render($param['module'], $data);
    }

    public function editRecord(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])) {
            ErrorController::createErr('Войдите в систему под своим логином!');
            Redirect::redirect("/login/checkUser");
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
            foreach ($data as $item) {
                if(!$item) {
                    ErrorController::createErr('Не все поля заполнены. Проверьте!');
                    return Redirect::redirect("previous");
                }
            }

            $id_rec = Request::getPost("id");

            if (isset($id_rec) && !empty($id_rec)) {

                $update = new RefillRecordAction();
                $result = $update->updateRecord($id_rec, $data);

                if (!is_string($result)) {
                    ErrorController::createSuccess('Данные обновлены!');
                    return Redirect::redirect("/refill/index");
                } else {
                    ErrorController::createErr('Данные не обновлены! Причина: '.$result);
                    return Redirect::redirect("previous");
                }
            } else {
                throw new Exception ("id не существует или не передан");
            }
    }

    public function deleteRecord($param){
        if (!isset($_SESSION['user'])) {
            ErrorController::createErr('Вы не вошли. Войдите.');
            return Redirect::redirect("/login/checkUser/");
        }

        $id = $param['id'];
        $del = new IntervalRecordAction();
        $res = $del->deleteRecord($id);
        if($res === true){
            ErrorController::createSuccess("Запись № $id - успешно удалена.");
            return Redirect::redirect("previous");
        }else{
            ErrorController::createErr($res);
            return Redirect::redirect("previous");
        }
    }
}
