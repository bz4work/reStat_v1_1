<?php
/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:23
 */

class Registration
{
    /**
     * Generaing registration form
     * @throws Exception
     */
    public function newUser(){
        $view = new View();
        return $view->render("regForm");
    }

    /**
     * Make new user
     * @throws Exception
     */
    public function createUser(){
        $data = [
                'login'=>Request::getPost('login'),
                'email'=>Request::getPost('email'),
                'pass'=>Request::getPost('pass'),
                'confirm_pass'=>Request::getPost('confirm_pass')
        ];
        $view = new View();

        $data = $this->checkEmptyFiled($data);
        if (array_key_exists('err',$data)){
            return $view->render('regForm',$data);
        }

        $data = $this->checkLength($data);
        if (array_key_exists('err',$data)){
            return $view->render('regForm',$data);
        }

        //если значения в полях pass и confirm_pass не совпадают -
        //возвращаем на страницу формы
        if ($data['pass'] != $data['confirm_pass']){
            $data['not_match_pass'] = 'Pass and confirm pass not match';
            return $view->render('regForm',$data);
        }

        //если занят логин и/или пароль -
        //возвращаем на страницу формы
        $data = $this->checkExist($data);

        if(array_key_exists('err',$data)){
            return $view->render('regForm', $data);
        }

        //шифруем пароль
        $crypt = new Crypt();
        $data['crypt_pass'] = $crypt->cryptPass($data['pass']);

        //заносим юзера в БД
        $add = new RegistrationModel();
        $result = $add->addUser($data);

        //если addUser вернул true - все ок
        //если вернул строку - не получилось добавить данные в БД
        if(is_bool($result) && $result == true){
            $name = $data['login'];
            unset($data);
            $data['success'] = $name." - user is registered successfully. Log In.";
            return $view->render('regForm',$data);
        }else{
            $data['error'] = 'The script is broken. Error:'.$result;
            return $view->render('regForm',$data);
        }
    }

    /**
     * Checks whether the username or email busy
     * @param $login - check that a login
     * @param $email - check that a email
     * @return bool - if login and email - available
     * @return array - if login and/or email - is busy
     * @throws Exception
     */
    public function checkExist($data){
        $email = $data['email'];
        $login = $data['login'];

        $userData = new UserGetInfoModel();

        //проверяем существуют ли данные
        //которые совпадают с введенными
        $userData->generateUserDataArray($email);
        if($userData->getUserInfoValue('email',$email)){
            $arr['email'] = 'exist';
        }

        //проверяем существуют ли данные
        //которые совпадают с введенными
        $userData->generateUserDataArray($login,"username");
        if($userData->getUserInfoValue('username',$login)){
            $arr['login'] = 'exist';
        }

        if(isset($arr)){
            foreach ($arr as $key=>$field) {
                if($field == 'exist'){
                    $data['error_'.$key] = 'has-error';
                    $data['error_'.$key.'_p'] = "$key already exist";
                    $data['err'] = 'err';
                }
            }
            return $data;
        }else{
            return $data;
        }

    }

    /**
     * Check the empty fields
     * @param $data
     * @return mixed
     */
    public function checkEmptyFiled($data){
        foreach ($data as $key=>$input) {
            if(!$input){
                //составляем имена и текста ошибок для возврата в форму
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Field $key not be empty";
                $data['err'] = 'err';
            }
        }
        return $data;
    }

    /**
     * Check the length of the value
     * @param $data
     * @return mixed
     */
    public function checkLength($data){
        foreach ($data as $key=>$value) {
            if($key == 'login' && strlen($value) < 3 ){
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Length of at least 3 characters";
                $data['err'] = 'err';
            }
            if($key == 'pass' && strlen($value) < 6 ){
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Length of at least 6 characters";
                $data['err'] = 'err';
            }
        }
        return $data;
    }
}