<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/11
 * Time: 下午5:13
 */

class SocketException extends Exception{

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
abstract class SocketConnection{

    abstract public function start();

    abstract public function stop();

    abstract public function send($socket, $data);

    abstract protected function getError();

    public function __construct($cof_arr = null)
    {
        if(empty($cof_arr)){
            return;
        }
        foreach($cof_arr as $key => $value){
            $this->$key = $value;
        }

    }

}

class SocketServer extends SocketConnection{

    public $ip = '127.0.0.1';
    public $port = '20004';


    public $domain = AF_INET;
    public $type = SOCK_STREAM;
    public $protocol = SOL_TCP;
    public $callback;//block

    public $sync = false;

    public $sendTimeOut = 1;
    public $recTimeOut = 1;

    private static $socket;
    private $clients = [];
    public $maxClient = 10;

    public function getSocket()
    {
        if(self::$socket == null){
            if(!self::$socket = socket_create($this->domain, $this->type, $this->protocol)){

                throw new SocketException('Create socket resource fail:' . $this->getError());
            };
        }
        return self::$socket;
    }

    protected function updateSocketOpt()
    {
        socket_set_option($this->getSocket(), SOL_SOCKET, SO_RCVTIMEO, ['sec'=>$this->recTimeOut, 'usec'=>0]);
        socket_set_option($this->getSocket(), SOL_SOCKET, SO_SNDTIMEO, ['sec'=>$this->sendTimeOut, 'usec'=>0]);
    }

    public function start()
    {
        $this->updateSocketOpt();

        if(!$res = socket_bind($this->getSocket(),$this->ip, $this->port)){
            throw new SocketException('Bind socket error:'. $this->getError() . "\n");
        }
        if(!$res = socket_listen($this->getSocket(), SOMAXCONN)){
            throw new SocketException('Listen port error:'. $this->getError() . "\n");
        }

        if($this->sync){
            $this->singleRun();
        }else{
            $this->multiRun();
        }
    }

    public function stop()
    {
        socket_shutdown($this->getSocket());
        socket_close($this->getSocket());
    }

    protected function getError()
    {
        return socket_strerror(socket_last_error($this->getSocket()));
    }

    public function send($socket, $data)
    {
        return socket_write($socket, $data, strlen($data));
    }

    private function singleRun(){
        do {

            if (($newSocket = @socket_accept($this->getSocket())) === false) {
                throw new SocketException('Accepts a connection on a socket error:' . $this->getError());
            }
            $msg = "Start connection.\n";

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

                $func = $this->callback;
                $func($data, $newSocket);

            } while (true);

            socket_close($newSocket);

        } while (true);

        $this->stop();
    }

    private function multiRun(){

        $read[] = $this->getSocket();
        do {
            $num_changed = socket_select($read, $NULL, $NULL, 0, 10);
            if($num_changed) {


                if (in_array($this->getSocket(), $read)) {

                    if (count($this->clients) < $this->maxClient) {

                        $this->clients[] = socket_accept($this->getSocket());
                    }

                }
            }

            foreach($this->clients as $key => $client) {

                if(in_array($client, $read)) {
                    $data = socket_read($client, 2048, PHP_NORMAL_READ);

                    if($data === false) {

                        socket_shutdown($client);
                        unset($this->clients[$key]);

                    } else {

                        $data = trim($data);

                        if($data == 'quit') {
                            socket_close($client);
                        }elseif($data == 'shutdown'){

                            break 2;
                        }else{
                            $func = $this->callback;
                            $func($data, $client);
                        }

                    }

                }

            }

            $read = $this->clients;
            $read[] = $this->getSocket();

        } while (true);

        $this->stop();
    }
}


$soc = new SocketServer();
$soc->callback = function ($data, $socket) use($soc){
    if($data ==1){
        $soc->send($socket,'123');
    }
};
$soc->start();

