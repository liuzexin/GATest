<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 2017/1/19
 * Time: 下午1:56
 */

class A {
    public static $property = 1;

    public function test(){
        echo static::$property;
    }
}

class B extends A{
    public static $property = 2;
}
$b = new B();

echo $b->test() . "\n";