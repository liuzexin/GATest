<?php

use app\components\WebsocketWidget;
?>
<div id="ga-dialog" title="对话中">
    <ul id="show-list"></ul>
    <textarea id="input-area" name="input-area" style="">
    </textarea>
</div>
<?= WebsocketWidget::widget([
    'clientOptions' => [
        'width' => 400,
        'height' => 600,
        'hide' => [
            'effect' => 'explode',
            'duration' => 1000
        ],
        'onClose'=>"function(){
            mySocket.close();
        }"
    ]
])?>
