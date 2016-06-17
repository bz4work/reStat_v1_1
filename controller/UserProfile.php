<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 17.06.2016
 * Time: 0:27
 */
class UserProfile
{
    public function index(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            return Redirect::redirect('previous');
        }
        $data = self::initProfile();
        $view = new View();
        return $view->render('userProfile',$data);

    }

    /**
     * инициализация и сбор данных для панели юзера
     * @return array|null
     */
    static public function initProfile(){
        if(!isset($_SESSION['user']) || empty($_SESSION['user'])){
            return self::$_data = null;
        }
        $id = $_SESSION['id'];
        //$lastRide = UserPanelModel::getLastSevices($id);

        $data = [
            "nextServicesList" => UserPanelModel::getLastSevices($id)
        ];

        return $data;
    }

    public function notifyOff(){
        $id = Request::getPost('id');
        if(isset($id) && !empty($id)){
            $exec = new UserProfileModel();
            $exec->setNotifyOff($_SESSION['id'],$id);
        }

        return Redirect::redirect('previous');
    }

}