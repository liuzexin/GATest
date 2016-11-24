<?php
/**
 * Created by PhpStorm.
 * User: xin
 * Date: 16/11/15
 * Time: 下午4:22
 */
namespace app\models;
use yii\base\Model;
use yii\web\UploadedFile;

class UploadModel extends Model{

    public $extensions = '';
    public $skipOnEmpty = true;
    public $maxFiles = 4;

    public $files;
    public function rules()
    {
        return [
          [['files'], 'file', 'skipOnEmpty' => $this->skipOnEmpty, 'extensions' => $this->extensions, 'maxFiles' => $this->maxFiles]
        ];
    }

    public function upload(){
        if ($this->validate()) {

            $this->files->saveAs('@runtime/image/' . $this->files->baseName . '.' . $this->files->extension);
            return true;
        } else {
            return false;
        }
    }
}