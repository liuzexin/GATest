<?php

namespace app\models;

use yii\base\Widget;

class TurntableWidget extends Widget{



    public function run()
    {
        return $this->render('turntable');
    }

    function getViewPath()
    {
        return '@app/views/site';
    }
}