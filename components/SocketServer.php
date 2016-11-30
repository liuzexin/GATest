<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/29
 * Time: 下午6:20
 */

namespace app\components;

class SocketServer extends SocketConnection{

    public $ip = '127.0.0.1';
    public $port = '20000';

    public $domain = AF_INET;// Internet Protocol,default use IP4 protocol.
    public $type = SOCK_STREAM;
    public $protocol = SOL_TCP;
    public $callback;//block

    public $sendTimeOut = 1;
    public $recTimeOut = 1;

    private static $socket;



    public function __get($name)
    {
        if($name == 'socket'){
            return $this->getSocket();
        }else if(!isset($this->$name)){
            throw new SocketException('Get unknown property');
        }else if($name == 'callback'){
          return $this->$name();
        }else{
            return $this->$name;
        }
    }

    public function __set($name, $value)
    {
        if(isset($this->$name) && $name != 'socket'){
            $this->$name = $value;
        }else{
            throw new SocketException('Set unknown property');
        }
    }

    public function getSocket(){

        if(self::$socket == null){
            if(!self::$socket = socket_create($this->domain, $this->type, $this->protocol)){

                throw new SocketException('Create socket resource fail:' . socket_strerror($this->socket));
            };
        }
        return self::$socket;
    }

    protected function updateSocketOpt(){
        socket_set_option($this->socket, SOL_SOCKET, SO_RCVTIMEO, ['sec'=>$this->recTimeOut, 'usec'=>0]);
        socket_set_option($this->socket, SOL_SOCKET, SO_SNDTIMEO, ['sec'=>$this->sendTimeOut, 'usec'=>0]);
    }

    public function start(){
        $this->updateSocketOpt();

        if(!$res = socket_bind($this->socket,$this->ip, $this->port)){
            throw new SocketException('Bind socket error:'. $this->getError() . "\n");
        }
        if(!$res = socket_listen($this->socket, SOMAXCONN)){
            throw new SocketException('Listen port error:'. $this->getError() . "\n");
        }

        do {

            if (empty($newSocket = @socket_accept($this->socket))) {
                throw new SocketException('Accepts a connection on a socket error:' . $this->getError());
            }
            $msg = "Start connection";

            $this->send($newSocket, $msg);

            do {
                if (false === ($data = @socket_read($newSocket, 2048, PHP_NORMAL_READ))) {
                    throw new SocketException("Read failed: reason: " . $this->getError() . "\n");
                }
                if (empty($data = trim($data))) {
                    continue;
                }
                if ($data == 'quit') {
                    break;
                }
                if ($data == 'shutdown') {
                    socket_close($newSocket);
                    break 2;
                }

                $this->$callback($data);
            } while (true);

            socket_close($newSocket);

        } while (true);

        $this->stop();
    }

    public function stop()
    {
        socket_close($this->socket);
    }

    protected function getError()
    {
        return socket_strerror(socket_last_error($this->socket));
    }

    public function send($socket, $data)
    {
        return socket_write($socket, $data, strlen($data));
    }
}


