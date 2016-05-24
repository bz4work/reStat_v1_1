<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 24.05.2016
 * Time: 1:11
 */
class Log{
    static private $_filename;

    public function __construct(){
        self::$_filename = Config::getConfig("log_file");
    }

    static public function writeToFile(){
        $count_param = func_num_args();

        $date_time = date("d.m.Y H:i:s",time());
        $request_method = $_SERVER['REQUEST_METHOD'];
        $user_ip = $_SERVER['REMOTE_ADDR'];
        $sess_name = isset($_SESSION['user'])? $_SESSION['user'] : "no_session_name";

        $error_text = "\n\n[Date&Time] |  [RequestMethod] | [SESSION_NAME] | [User IP]\n";
        $error_text .= '['.$date_time.'] | ['.$request_method.'] | ['.$sess_name.'] | IP:['.$user_ip."]\n";
        $error_text .= "[Class::Method] | [File] | [Line] | [Arg1] | [Arg2] | [etc...]\n";

        for ($i = 0; $i <= $count_param-1; $i++){

            $error_text .= '['.func_get_arg($i).'] | ';
        }

        $result = file_put_contents(self::$_filename, $error_text, FILE_APPEND);
    }

}