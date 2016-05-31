<?php
/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 11:25
 */
class Login{

    /**
     * check whether the user is logged in
     * @throws Exception
     */
    public function checkUser(){
        if(isset($_SESSION['user'])){
            /*$userData = new UserDB();
            $userData->generateUserDataArray($_SESSION['user'],"username");
            $id = $userData->getUserInfo("id");
            $refill_content->setUserId($id);*/
            $refill_content = new Refill();
            return $refill_content->index();
        }else{
            $this->formLogin();
        }
    }

    /**
     * login and password entered by the user verification
     * @throws Exception
     */
    public function verificationUser(){

        $post_email = Request::getPost("email");
        $post_password = Request::getPost("pass");

        if(isset($post_email,$post_password) && !empty($post_password) && !empty($post_email)){

            $userData = new UserDB();

            if($userData->generateUserDataArray($post_email) == "false"){
                Result::errorCreate("globalError","Такого юзера не существуеты");
                return Redirect::redirect(Config::getConfig("logCheck"));
            }

            try{
                $pass_user_db = $userData->getUserInfo("password");
            }catch(Exception $e){
                $err_txt = $e->getMessage();
                Result::errorCreate("globalError",$err_txt);
                return Redirect::redirect(Config::getConfig("logCheck"));
            }

            if($post_password == $pass_user_db) {

                $id = $userData->getUserInfo("id");
                $username = $userData->getUserInfo("username");

                $createSession = new Session("user",$username);
                $createSession = new Session("id",$id);

                return Redirect::redirect(Config::getConfig('home'));
            }else{
                throw new Exception ("Пароль или логин введены не верно");
            }
        }else{
            Result::errorCreate("globalError","Не все поля заполнены!");
            return Redirect::redirect(Config::getConfig("logCheck"));
        }
    }

    /**
     * create login form
     * @throws Exception
     */
    public function formLogin(){
        $view = new View();
        $url = Config::getConfig('logVer');
        $view->render('loginForm',$arr='',$url);
    }

    /**
     * destroy user sessions
     * @throws Exception
     */
    public function logout(){
        session_destroy();
        Redirect::redirect(Config::getConfig("defaultRoute"));
    }
}