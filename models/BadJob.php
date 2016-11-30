<?php

class BadJob
{
    /* this->args
     * 1.订单号
     * 取到订单号直接去开卡
     *
     */
    public function perform()
    {
        error_log(123,3,'/tmp/error.log');
    }
}