<?php
/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:25
 */
class Login{

    public function checkUser(){

        if(isset($_SESSION['user'])){

            $userData = new UserDB();
            $userData->generateUserDataArray($_SESSION['user'],"username");

            //нужно дли это?
            if (is_array($userData)){
                throw new Exception ("Не правильно передано имя пользователя из сессии".__METHOD__);
            }

            $id = $userData->getUserInfo("id");

            $refill_content = new Refill();

            $refill_content->setUserId($id);

            return $refill_content->index();

        }else{
            $this->formLogin();
        }
    }


    public function verificationUser(){

        $post_email = Request::getPost("email");
        $post_password = Request::getPost("pass");

        if(isset($post_email,$post_password) && !empty($post_password) && !empty($post_email)){

            $userData = new UserDB();

            if($userData->generateUserDataArray($post_email) == "false"){
                Result::errorCreate("globalError","Такого юзера не существуеты");
                return Redirect::redirect("index.php?login=checkUser");
            }

            try{
                $pass_user_db = $userData->getUserInfo("password");
            }catch(Exception $e){
                $err_txt = $e->getMessage();
                Result::errorCreate("globalError",$err_txt);
                return Redirect::redirect("index.php?login=checkUser");
            }

            if($post_password == $pass_user_db) {

                $id = $userData->getUserInfo("id");
                $username = $userData->getUserInfo("username");

                $createSession = new Session("user",$username);
                $createSession = new Session("id",$id);

                $refill_content = new Refill();
                $refill_content->setUserId($id);

                return $refill_content->index();
            }else{
                throw new Exception ("Пароль или логин введены не верно");
            }
        }else{
            Result::errorCreate("globalError","Не все поля заполнены!");
            return Redirect::redirect("index.php?login=checkUser");
        }
    }


    public function formLogin(){
        $view = new View();
        //$view->renderLoginForm();
        $view->render('loginForm');
    }

    public function logout(){
        session_destroy();
        Redirect::redirect("index.php?page=main");
    }
}