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
            $page = new Page();
            return $page->main();
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
                return Redirect::redirect("/page/main/");
            }

            $check = new Crypt();

            if($check->compare($post_email,$post_password)){
                //пароль подошел
                $id = $userData->getUserInfo("id");
                $username = $userData->getUserInfo("username");
                $createSession = new Session("user",$username);
                $createSession = new Session("id",$id);
                return Redirect::redirect("/page/main/");
            }else{
                //пароль не подошел
                Result::errorCreate("globalError","Пароль введен не верно!");
                return Redirect::redirect("/page/main/");
            }
        }else{
            Result::errorCreate("globalError","Не все поля заполнены!");
            return Redirect::redirect("/page/main/");
        }
    }

    /**
     * create login form
     * @throws Exception
     */
    public function formLogin(){
        $view = new View();
        return $view->render('loginForm');
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