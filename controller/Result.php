<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 24.05.2016
 * Time: 14:44
 */
class Result{

    public function destroyResultVar(){
        //unset($_SESSION['result']);
        unset($_SESSION["result"]);
        Redirect::redirect("index.php?refill=index");
    }

    public function destroyErrorVar(){
        //unset($_SESSION['result']);
        unset($_SESSION["error"]);
        Redirect::redirect("index.php?refill=index");
    }

}