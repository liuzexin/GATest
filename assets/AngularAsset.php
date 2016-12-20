<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/12/20
 * Time: 下午5:03
 */

namespace app\assets;
use yii\web\AssetBundle;

class AngularAsset extends AssetBundle
{
    public $sourcePath = '@bower';

    public $js = [
        'angular/angular.js'
    ];
}