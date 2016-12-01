<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/30
 * Time: 下午6:31
 */
class SocketException extends Exception{

    public function __construct($message, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
abstract class SocketConnection{

    public $ip = '127.0.0.1';
    public $port = '20000';

    public $callback;

    public $domain = AF_INET;
    public $type = SOCK_STREAM;
    public $protocol = SOL_TCP;


    public $sendTimeOut = 1;
    public $recTimeOut = 1;

    protected static $socket;

    abstract public function start();

    abstract public function send($socket, $data);

    public function stop()
    {
        socket_close($this->getSocket());
    }

    public function __construct($cof_arr = null)
    {
        set_time_limit(0);
        if(empty($cof_arr)){
            return;
        }
        foreach($cof_arr as $key => $value){
            $this->$key = $value;
        }

    }

    protected function getError()
    {
        return socket_strerror(socket_last_error($this->getSocket()));
    }

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
}

class SocketServer extends SocketConnection{

    public $singleMode = false;


    private $clients = [];
    public $maxClient = 10;

    public function __construct($cof_arr = null)
    {
        parent::__construct($cof_arr);
    }

    public function send($socket, $data)
    {
        return socket_write($socket, $data, strlen($data));
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

        if($this->singleMode){
            $this->singleRun();
        }else{
            $this->multiRun();
        }
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
                elseif ($data == 'quit') {
                    break;
                }
                elseif ($data == 'shutdown') {
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
                    if (false === ($data = @socket_read($client, 2048, PHP_NORMAL_READ))) {
                        socket_close($client);
                        unset($this->clients[$key]);
                    }
                    if (empty($data = trim($data))) {
                        continue;
                    }
                    elseif ($data == 'quit') {
                        socket_close($client);
                        unset($this->clients[$key]);
                        break;
                    }
                    elseif ($data == 'shutdown') {
                        break 2;
                    }
                    else{
                        $func = $this->callback;
                        $func($data, $client);
                    }
                }
            }

            $read = $this->clients;
            $read[] = $this->getSocket();

        } while (true);

        $this->stop();
    }

}


class SocketClient extends SocketConnection{

    public $sync = false;
    public $sendData = '';

    public function start()
    {
        $this->updateSocketOpt();
        if(false === socket_connect($this->getSocket(), $this->ip, $this->port)){
            throw new SocketException('Can\'t connect the server:' . $this->getError());
        }

        $allData = null;
        while(true){
            socket_recv($this->getSocket(),$data, 2048);
            if($data === NULL){
                throw new SocketException('Connection terminated unexpectedly:' . $this->getError());
            }
            if($data == ''){
                if(!empty($this->callback)){
                    $func = $this->callback;
                    $func($data, $this->getSocket());
                    break;
                }
            }else{
                $allData .= $data;
            }
        }
        $this->stop();
        return $allData;
    }


    public function updateSocketOpt()
    {
        parent::updateSocketOpt();
        $this->sync?null:socket_set_nonblock($this->getSocket());
    }

    public function send($socket, $data)
    {
        return socket_send($socket, $data, strlen($data), MSG_OOB);
    }
}


$soc = new SocketServer([
    'singleModel' =>true
]);
$soc->callback = function ($data, $socket) use($soc){

    echo 'server receive:' . $data ."\n";
    $soc->send($socket, 'adadasdasdasdadadas'."\n\r");
};
$soc->start();