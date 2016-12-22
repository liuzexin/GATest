<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/12/22
 * Time: 下午2:42
 */
namespace app\assets;
use yii\web\AssetBundle;

class CaptchaAsset extends AssetBundle{

    public $sourcePath = '@web';

    public $js = [
      'js/ga.captcha.js'
    ];
}
