<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/8
 * Time: 下午6:05
 */
namespace app\assets;

use yii\web\AssetBundle;
class DropzoneAsset extends AssetBundle{
    public $sourcePath = YII_DEBUG ? '@bower/dropzonejs/dist/' : '@bower/dropzonejs/dist/min';

    public $js = YII_DEBUG ? [
        'dropzone.js',
        'dropzone-amd-module.js'
    ] : [
        'dropzone.min.js',
        'dropzone-amd-module.min.js'
    ];

    public $css = YII_DEBUG ? [
        'basic.css',
        'dropzone.css'
    ] : [
        'dropzone.min.css',
        'basic.min.css'
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}