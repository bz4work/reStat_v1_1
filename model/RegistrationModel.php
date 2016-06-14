<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 07.06.2016
 * Time: 20:43
 */

class RegistrationModel
{
    public function addUser($data){
        $us = $data['login'];
        $pass = $data['crypt_pass'];
        $email = $data['email'];

        $sql_add_user = "INSERT INTO `users` (`username`,`password`,`email`,activated)
                VALUE ('$us', '$pass','$email',1);";


            if(WorkDB::insertData($sql_add_user)){
                return true;
            }else{
                return 'user not added!';
            }


    }

}