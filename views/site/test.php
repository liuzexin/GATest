<?php
use app\components\WebsocketWidget;
?>

<?=
    WebsocketWidget::widget(
      [
          'clientOptions' => [
              'height' => 600,
              'width' => 400,
          ]
      ]
    );
?>
