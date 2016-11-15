<?php

use app\assets\DropzoneAsset;

DropzoneAsset::register($this);
?>
<?= \yii\widgets\ActiveForm::widget()?>
<?php $form = \yii\widgets\ActiveForm::begin([
    'options'=>[
        'class'=>'dropzone'
    ],
    'action'=>\yii\helpers\Url::to(['site/dropzone']),
    'id'=> 'my-awesome-dropzone'
])
?>

<?=$form->field($model, 'files')->fileInput()?>

<?=\yii\widgets\ActiveForm::end()?>
<!--<form action="/file-upload" class="dropzone" id="my-awesome-dropzone">-->
<!--</form>-->