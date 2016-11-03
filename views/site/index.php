<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

?>
<?= \app\models\TurntableWidget::widget(['pointerImagePath' => '/image/pointer1.png','scrollType' => \app\models\TurntableWidget::TURNTABLE_SCROLL])?>
