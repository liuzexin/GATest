<?php
use ga\turntable\TurntableWidget;
use ga\turntable\TurntableAsset;
TurntableAsset::register($this);
?>
<?= TurntableWidget::widget(['scrollType'=>TurntableWidget::TURNTABLE_SCROLL])?>
