<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 2017/1/5
 * Time: 上午9:29
 */
namespace app\components;
use yii\jui\Widget;
use app\assets\WebsocketAsset;

class WebsocketWidget extends Widget{

    public function run()
    {
        $this->js();
        return $this->registerWidget('dialog', 'custom-dialog');
    }

    public function js(){
        $js = <<<JS
        $(function(){

            $('#input-area')[0].addEventListener('keydown',function(e){
                if(e.keyCode!=13)
                return;
                e.preventDefault();
                $('#show-list').append('<li class="your" style="border: 1px solid red; text-align: right">'+ this.value +'</li>');
                $('#show-list')[0].scrollTop = $('#show-list')[0].scrollHeight;
                this.value = '';
            });

        });
JS;
        $this->getView()->registerJs($js);
    }

    protected function registerWidget($name, $id = null)
    {
        if ($id === null) {
            $id = $this->options['id'];
        }
        WebsocketAsset::register($this->getView());
        $this->registerClientEvents($name, $id);
        $this->registerClientOptions($name, $id);
    }
}