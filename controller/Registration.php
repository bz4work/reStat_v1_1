<?php
/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:23
 */

class Registration
{
    public function newUser(){
        $view = new View();
        //return $view->render("registrationForm");
        return $view->render("regForm");
    }

    public function createUser(){
        $data = [
                'login'=>Request::getPost('login'),
                'email'=>Request::getPost('email'),
                'pass'=>Request::getPost('pass'),
                'confirm_pass'=>Request::getPost('confirm_pass')
        ];

        $count = 4;
        $view = new View();

        foreach ($data as $key=>$input) {
            if(!$input){
                //составляем имена и текста ошибок для возврата в форму
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Field $key not be empty";
                $count -= 1;
            }
        }
        //если массив меньше 4х елементов - что-то не правильно -
        //возвращаем на страницу формы
        if ($count < 4){
            return $view->render('regForm',$data);
        }

        foreach ($data as $key=>$value) {
            if($key == 'login' && strlen($value) < 3 ){
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Length of at least 3 characters";
                $count -= 1;
            }
            if($key == 'pass' && strlen($value) < 6 ){
                $data['error_'.$key] = 'has-error';
                $data['error_'.$key.'_p'] = "Length of at least 6 characters";
                $count -= 1;
            }
        }

        //если значение строк login и/или pass меньше заданного значения
        //возвращаем на страницу формы
        if ($count < 4){
            return $view->render('regForm',$data);
        }

        if ($data['pass'] != $data['confirm_pass']){
            $data['not_match_pass'] = 'Pass and confirm pass not match';
            return $view->render('regForm',$data);
        }

        $crypt = new Crypt();

        $data['crypt_pass'] = $crypt->cryptPass($data['pass']);

        unset($data['pass'], $data['confirm_pass']);

        $add = new RegistrationModel();
        $result = $add->addUser($data);

        if(is_bool($result) && $result == true){
            //if true
            unset($data);
            $data['success'] = 'Congratulations, the registration is successfully completed. Log In.';
            return $view->render('regForm',$data);
        }else{
            $data['error'] = 'The script is broken. Error:'.$result;
            return $view->render('regForm',$data);
        }
    }

}