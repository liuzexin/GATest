<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/30
 * Time: 上午9:07
 */
namespace app\components;
abstract class SocketConnection{

    abstract public function start();

    abstract public function stop();

    abstract public function send($socket, $data);

    abstract protected function getError();

    public function __construct($cof_arr)
    {
        foreach($cof_arr as $key => $value){
            $this->$key = $value;
        }

    }

}