<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/23
 * Time: 上午11:26
 */

namespace app\commands;
use yii\base\Controller;

class ResqueController extends Controller
{
    public function actionTest(){

       echo \Yii::$app->resque->enqueue('default', 'BadJob', [1], true);

    }

    public function actionIndex(){
        $QUEUE = getenv('QUEUE');
        if(empty($QUEUE)) {
            die("Set QUEUE env var containing the list of queues to work.\n");
        }

        require_once  \Yii::getAlias('@vendor'). '/chrisboulton/php-resque/lib/Resque.php';
        require_once  \Yii::getAlias('@vendor'). '/chrisboulton/php-resque/lib/Resque/Worker.php';

        if(file_exists(\Yii::getAlias('@app').'/composer.json')){
            $this->includeFile(\Yii::getAlias('@app'));
        }else{
            $this->includeFile(\Yii::getAlias('@backend'));
            $this->includeFile(\Yii::getAlias('@frontend'));
            $this->includeFile(\Yii::getAlias('@frontend'));
            $this->includeFile(\Yii::getAlias('@console'));
            $this->includeFile(\Yii::getAlias('@common'));
        }



        $REDIS_BACKEND = getenv('REDIS_BACKEND');
        if(!empty($REDIS_BACKEND)) {
            \Resque::setBackend($REDIS_BACKEND);
        }

        $logLevel = 0;
        $LOGGING = getenv('LOGGING');
        $VERBOSE = getenv('VERBOSE');
        $VVERBOSE = getenv('VVERBOSE');
        if(!empty($LOGGING) || !empty($VERBOSE)) {
            $logLevel = \Resque_Worker::LOG_NORMAL;
        }
        else if(!empty($VVERBOSE)) {
            $logLevel = \Resque_Worker::LOG_VERBOSE;
        }

        $APP_INCLUDE = getenv('APP_INCLUDE');
        if($APP_INCLUDE) {
            if(!file_exists($APP_INCLUDE)) {
                die('APP_INCLUDE ('.$APP_INCLUDE.") does not exist.\n");
            }

            require_once $APP_INCLUDE;
        }

        $interval = 5;
        $INTERVAL = getenv('INTERVAL');
        if(!empty($INTERVAL)) {
            $interval = $INTERVAL;
        }

        $count = 1;
        $COUNT = getenv('COUNT');
        if(!empty($COUNT) && $COUNT > 1) {
            $count = $COUNT;
        }

        if($count > 1) {
            for($i = 0; $i < $count; ++$i) {
                $pid = pcntl_fork();
                if($pid == -1) {
                    die("Could not fork worker ".$i."\n");
                }
                // Child, start the worker
                else if(!$pid) {
                    $queues = explode(',', $QUEUE);
                    $worker = new \Resque_Worker($queues);
                    $worker->logLevel = $logLevel;
                    fwrite(STDOUT, '*** Starting worker '.$worker."\n");
                    $worker->work($interval);
                    break;
                }
            }
        }
// Start a single worker
        else {
            $queues = explode(',', $QUEUE);
            $worker = new \Resque_Worker($queues);
            $worker->logLevel = $logLevel;

            $PIDFILE = getenv('PIDFILE');
            if ($PIDFILE) {
                file_put_contents($PIDFILE, getmypid()) or
                die('Could not write PID information to ' . $PIDFILE);
            }

            fwrite(STDOUT, '*** Starting worker '.$worker."\n");
            $worker->work($interval);
        }

    }

    private function includeFile($path){
        $job_dir_name = $path . '/models';
        $dir = dir($job_dir_name);
        while(($file = $dir->read()) !== false){
            if(is_dir($job_dir_name."/".$file) AND ($file!=".") AND ($file!="..")) {
                continue;
            } else {
                if(preg_match('/\w+Job.php/',$file)){
                    echo $file;
                    include_once $job_dir_name.DIRECTORY_SEPARATOR.$file;
                }
            }
        }
        $dir->close();
    }
}