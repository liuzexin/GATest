<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/10/31
 * Time: 下午4:47
 */

namespace app\assets;


use yii\web\View;

class LessAsset extends AppAsset
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
      'js/less.js'
    ];

    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}