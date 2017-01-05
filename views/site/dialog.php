<?php

use app\components\WebsocketWidget;
?>
<div id="custom-dialog" title="对话中">
    <ul class="" id="show-list" style="position: relative;height: 65%;width: 100%;top: 0;list-style: none;overflow: auto;">
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
        <li class="your" style="border: 1px solid red; text-align: right">12131231</li>
        <li class="other" style="border: 1px solid red; text-align: left">235465</li>
    </ul>
    <textarea id="input-area" name="input-area" style="position: relative;top: 10px;width: 80%; height: 30%;resize: none;margin-left: 10%;">
    </textarea>
</div>
<?= WebsocketWidget::widget([
    'clientOptions' => [
        'width' => 400,
        'height' => 600,
        'hide' => [
            'effect' => 'explode',
            'duration' => 1000
        ]
    ]
])?>
