<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 20.05.2016
 * Time: 12:14
 */
class Request{
    /**
     * @param $key
     * @return bool
     */
    static public function getPost($key)
    {
        if (isset($_POST[$key])) {
            return self::clearData($_POST[$key]);
        } else {
            return false;
        }
    }

    /**
     * @param $key
     * @return bool|float|int|string
     */
    static public function getGet($key)
    {
        if (isset($_GET[$key])) {
            return self::clearData($_GET[$key]);
        } else {
            return false;
        }
    }

    /**
     * @param $data
     * @param string $type
     * @return float|int|string
     */
    static public function clearData ($data, $type = "int"){
        //задаем набор символов для escape_string
        DB::getDB()->set_charset("utf8");

        $data = strip_tags($data);
        $data = trim($data);

        /*if ($type == "float"){
            $data = (float)$data;
        }elseif ($type == "string"){
            $data = (string)$data;
        }else {
            $data = (int)$data;
        }*/

        $data = DB::getDB()->escape_string($data);

        return $data;
    }
}