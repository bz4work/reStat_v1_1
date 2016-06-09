<?php

/**
 * Created by PhpStorm.
 * User: slim
 * Date: 09.06.2016
 * Time: 14:25
 */
class BaseController
{
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

    public function setRideReserve(){

    }

}