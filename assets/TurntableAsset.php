<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/10/31
 * Time: 下午4:21
 */

namespace app\assets;

use yii\web\AssetBundle;

class TurntableAsset extends  AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
      'css/turntable.css'
    ];

    public $js = [
      'js/ga-turntable.js'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'app\assets\LessAsset'
    ];
}