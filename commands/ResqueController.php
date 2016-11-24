<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/22
 * Time: 下午5:45
 */

namespace app\commands;

use Yii;

class ResqueController
{
    public function actionStart(){
        $vendor = Yii::getAlias('@vendor');
        $dir = $vendor.'/chrisbouluton/';
    }
}