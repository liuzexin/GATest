<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/11
 * Time: 下午5:13
 */

class A{
    public $a ;
    public function __construct()
    {
        $this->a = 1;
    }
}

class b extends A{
    public function __construct()
    {
        parent::__construct();
        $this->a =2;

    }

    public function getError(){
        if(error_get_last()){
            print_r(error_get_last());
        }
        die('stop');
    }
}

register_shutdown_function([new b(), 'getError']);




