<?php

require "../vendor/lib-custom-func.php";

class Test extends PHPUnit_Framework_TestCase
{
    protected function setUp(){}
    protected function tearDown(){}

    public function testGetBalance(){
        $bal = new Balance();

        $this->assertTrue(!is_string($bal->getBalance("2")));
    }
}