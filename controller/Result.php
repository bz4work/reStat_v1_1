<?php

/**
 * Created by PhpStorm.
 * User: Slimline
 * Date: 24.05.2016
 * Time: 14:44
 */
class Result{

    public function destroyResultVar(){
        unset($_SESSION["result"]);
        Redirect::redirect("index.php?refill=index");
    }

    public function destroyErrorVar(){
        unset($_SESSION["error"]);
        Redirect::redirect("index.php?refill=index");
    }

    public function destroyAddResultVar(){
        unset($_SESSION["add_result"]);
        Redirect::redirect("index.php?refill=generateFormAddRecord");
    }

    public function destroyAddErrorVar(){
        unset($_SESSION["add_error"]);
        Redirect::redirect("index.php?refill=generateFormAddRecord");
    }

}