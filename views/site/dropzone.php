<?php

use app\assets\UploadAsset;
UploadAsset::register($this);
use devgroup\dropzone\DropZone;
?>
    <div id="my">

    </div>

<?php
echo DropZone::widget(
    [
        'name' => 'file', // input name or 'model' and 'attribute'
        'url' => '', // upload url
        'storedFiles' => [], // stores files
        'eventHandlers' => [], // dropzone event handlers
        'sortable' => true, // sortable flag
        'sortableOptions' => [], // sortable options
        'htmlOptions' => [], // container html options
        'options' => [], // dropzone js options
    ]
);
