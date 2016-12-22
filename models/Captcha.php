<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/12/22
 * Time: 下午2:25
 */

namespace app\models;
use yii\widgets\InputWidget;
use app\assets\CaptchaAsset;
use yii\helpers\Html;

class Captcha extends InputWidget{

    public $captchaAction = 'site/verify';

    public $template = '{input}{image}';

    public $imageOptions;

    public function run(){

        if ($this->hasModel()) {
            $input = Html::activeTextInput($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textInput($this->name, $this->value, $this->options);
        }
        $route = $this->captchaAction;

        $image = Html::img($route, $this->imageOptions);
        echo strtr($this->template, [
            '{input}' => $input,
            '{image}' => $image,
        ]);
    }
}