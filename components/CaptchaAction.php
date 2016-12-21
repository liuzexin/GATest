<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/12/21
 * Time: 上午10:14
 */

namespace app\components;

use yii\base\Action;
use yii\base\Exception;

class CaptchaAction extends Action
{

    public $width = 120;

    public $height = 70;

    public $fontFile = './HansKendrickV-Regular.ttf';

    public $maxAngle = 15;

    public $minAngle = -15;
    /**
     * @var int If set more than six, it still is six.
     */
    public $maxChar = 6;

    public $maxFontSize = 20;

    public $minFontSize = 18;

    protected $randomString = '';

    protected $imageResource;

    private $noisyPoints = 50;

    private $maxLine = 3;

    public function beforeRun(){

        parent::beforeRun();
        if(extension_loaded('gd') === false){
            throwException(new Exception("GA Library not found."));
        }
    }

    public function run(){

        $this->changeHTTPHeader();
        $image = $this->getImageResource();

        $this->draw($image);

        $this->noisyImage($image);

        return $this->outputImage($image);
    }

    public function getImageResource(){

        if(empty($this->imageResource)){
            $this->imageResource = imagecreatetruecolor($this->width, $this->height);
        }
        return $this->imageResource;
    }


    public function draw($image){


        $bgColor = imagecolorallocate($image, 255, 255, 255);
        imagefilledrectangle($image, 0, 0, $this->width, $this->height, $bgColor);

        if($this->maxChar > 6){
            $this->maxChar = 6;
        }

        $width = $this->width / 6;

        for($i = 0; $i < $this->maxChar; $i++){
            $size = mt_rand($this->minFontSize, $this->maxFontSize);
            $angle = mt_rand($this->minAngle, $this->maxAngle);
            $x = $i * $width;
            $y = mt_rand(0, $this->height - imagefontheight($size));
            imagettftext($image ,$size ,$angle, $x, $y , $this->randColor($image), $this->fontFile, substr($this->getRandomString(), $i, 1));
        }
    }

    public function noisyImage($image){

        for($i = 0; $i < $this->noisyPoints; $i++){
            imagesetpixel($image, mt_rand(0, $this->width), mt_rand(0, $this->height), $this->randColor($image));
        }

        for($i = 0; $i < $this->maxLine; $i++){
            imagearc($this->getImageResource(), mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand(0, $this->width), mt_rand(0, $this->height), mt_rand($this->minAngle, $this->maxAngle), mt_rand($this->minAngle, $this->maxAngle), $this->randColor($this->getImageResource()));
        }
    }

    public function outputImage($image){

        ob_start();
        imagepng($image);
        imagedestroy($image);
        $buff = ob_get_clean();
        return $buff;
    }

    protected function randColor($image){

        return imagecolorallocate($image, mt_rand(0, 220), mt_rand(0, 220), mt_rand(0, 220));
    }

    public function getRandomString(){

        if(empty($this->randomString)){
            $chars = '123456789zxcvbnmasdfghjklqwertyuiopZXCVBNMASDFGHJKLQWERTYUIO';
            for ($i = 0; $i < $this->maxChar; $i++) {
                $this->randomString .= substr($chars, mt_rand(0, 61), 1);
            }
        }
        return $this->randomString;
    }

    public function changeHTTPHeader(){
//        $header = \Yii::$app->response->getHeaders();
        \Yii::$app->getResponse()->getHeaders()
            ->set('Pragma', 'public')
            ->set('Expires', '0')
            ->set('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->set('Content-Transfer-Encoding', 'binary')
            ->set('Content-type', 'image/png');
    }
}