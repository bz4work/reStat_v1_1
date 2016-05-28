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
            Result::errorCreate("globalError","Эта страница Вам не доступна, войдите.");
            return Redirect::redirect("/login/checkUser/");
        }

        $getRecord = new IntervalRecordAction();
        $this->intervalsData = $getRecord->getRecord($_SESSION['id']);

        $renderViewRefill = new View();
        return $renderViewRefill->render("intervals", $this->intervalsData);
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
            "finish_odo" => Request::getPost('finish_odo'),
            "start_date" => Request::getPost('start_date'),
            "interval_days" => Request::getPost('interval_days'),
            //"finish_date" => Request::getPost('finish_date'),
            "comment" => Request::getPost('comment'),
            "notify" => Request::getPost('notify'),

        );

        $interval_hours = $data['interval_days']*24;
        $string_finish_date = date("Y-m-d",time()+3600*$interval_hours);
        Request::setPost("finish_date",$string_finish_date);
        $data['finish_date'] = Request::getPost('finish_date');


        $id_intervals = explode("_",$data['name_interval']);
        $data['name_interval'] = $id_intervals[1];


        $add = new IntervalRecordAction();
        try{
            $add->createRecord($data);
        }catch(Exception $e){
            $err_text = $e->getMessage();
            Result::errorCreate("globalError",$err_text);
        }

        return Redirect::redirect("/serviceIntervals/index/");
    }

    public function generateFormAddRecord($param){
        if(isset($_SESSION['user']) && !empty($_SESSION['user'])){

            $names = new IntervalRecordAction();
            try {
                $this->intervalsData = $names->getNameIntervals($_SESSION['id']);
            }catch(Exception $e){
                $this->intervalsData = $e->getMessage();
                /*$err_txt = $e->getMessage();
                Result::errorCreate("globalError",$err_txt);
                Redirect::redirect();*/
            }

            $formAddRecordView = new View();
            return $formAddRecordView->render($param['module'],$this->intervalsData);
        }else{
            Result::errorCreate("globalError","Войдите в систему под своим логином!");
            Redirect::redirect("/login/checkUser/");
        }

    }
}