<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 10:23
 */
class Crypt
{
    public function cryptPass($pass){
        $salt = '$2aysn07$gforsa07$lt$';
        $str = md5($salt.md5($salt.$pass.$salt).$salt);
        $crypt_pass = crypt($str,$salt);
        return $crypt_pass;
    }

    public function compare($email, $pass)
    {
        $user = new UserGetInfoModel();
        $user->generateUserDataArray($email, 'email');

        $passDB = $user->getUserInfoValue('password');

        $pass = $this->cryptPass($pass);

        if ($pass == $passDB) {
            return true;
        } else {
            return false;
        }


    }

}