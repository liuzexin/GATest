<?php

namespace app\models;

use yii\base\Widget;
use yii\helpers\Url;

class TurntableWidget extends Widget{


    const POINTER_SCROLL = 'POINTER_SCROLL';
    const TURNTABLE_SCROLL = 'TURNTABLE_SCROLL';
    public $deg;
    public $scrollType;
    public $animateTime;//microseconds not seconds;
    public $pointerCallback = null ;//important JS callback code here.If the pointer complete animation will trigger this function.
    public $turntableCallback = null;//important JS callback code here.If the turntable complete animation will trigger this function.

    public $pointerImagePath = 'image/pointer.png'; //650 * 600
    public $turntableImagePath = 'image/turntable.png';//450 * 450
    public $turntableBGImagePath = 'image/turntable-bg.jpg';//228 * 228
    public function init(){
        parent::init();
        if(!isset($this->deg)){
            $this->deg = 6000;
        }
        if(!isset($this->scrollType)){
            $this->scrollType = self::POINTER_SCROLL;
        }
        if(!isset($this->animateTime)){
            $this->animateTime = 5000;
        }

    }

    public function run()
    {
        $view = $this->getView();
        $js[] = "$('.ga-pointer').css('background','url($this->pointerImagePath) no-repeat center');";
        $js[] = "$('.ga-turntable-bg').css('background','url($this->turntableBGImagePath) no-repeat center');";
        $js[] = "$('.ga-turntable').css('background','url($this->turntableImagePath) no-repeat center');";
        $js[] = "$(document).ready(function(){";
        $js[] = "$('.ga-pointer').click(function(){";
        if ($this->scrollType == self::TURNTABLE_SCROLL) {
            $callback = $this->turntableCallback ? $this->turntableCallback : 'null';
            $js[] = "$('.ga-turntable').animateRotate($this->deg,$this->animateTime,'swing',$callback);";
            $js[] = "$('.ga-pointer').animateRotate(-$this->deg,$this->animateTime,'swing');";
        } else {
            $callback = $this->pointerCallback ? $this->pointerCallback : 'null';
            $js[] = "$('.ga-pointer').animateRotate($this->deg,$this->animateTime,'swing',$callback);";
        }

        $js[] = "}); });";
        $jsCode = implode(' ',$js);
        $view->registerJS($jsCode);
        return $this->render('turntable');
    }

    function getViewPath()
    {
        return '@app/views/site';
    }


}