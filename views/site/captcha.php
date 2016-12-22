<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/12/22
 * Time: 下午3:38
 */
$this->title = '测试';
use yii\helpers\Html;
?>
<?= Html::beginForm('site/test', 'post')?>
<?= \app\models\Captcha::widget([
    'name' => 'captcha',
    'template' => '<label for="captcha">验证码</label>&emsp;&emsp;{input}{image}',
    'options' => ['id' => 'captcha'],
]);?>
<?= Html::submitButton('提交')?>
<?= Html::endForm()?>

