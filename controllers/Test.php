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
}

$b = new b();

echo $b->a;