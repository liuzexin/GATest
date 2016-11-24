<?php
namespace app\models\resque;
use yii\base\Model;
class BadJob extends Model
{
    public function perform()
    {
        throw new Exception('Unable to run this job!');
    }
}