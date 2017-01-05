<?php

namespace app\controllers;

use app\models\UploadModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\CaptchaValidator;

class SiteController extends Controller
{
//    private $status;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'verify'=>[
                'class' => 'ga\captcha\CaptchaAction',
            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
//        error_log(var_export(Yii::$app->request),3,'/tmp/error_test.log');
//        return $this->render('index');
//        echo mt_rand(-15, 15);
        return $this->render('dialog');
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        $id = Yii::$app->request->post();
        error_log(var_export($id,true),3,'/tmp/id.log');
        echo 1;
        var_dump($id);
    }

    public function actionDropzone(){
        $fileName = 'file';
        $uploadPath = '@runtime/image';
        error_log(var_export(1,true),3,'/tmp/error.log');
        error_log(var_export($_FILES,true),3,'/tmp/error.log');
        if (isset($_FILES[$fileName])) {
            $file = UploadedFile::getInstanceByName($fileName);


            if ($file->saveAs($uploadPath . '/' . $file->name)) {
                //Now save file data to database
                fputs();
                echo 'success';
            }
        }else{
            echo 'false';
        }
    }

    public function getStatus(){
        return 1;
    }

    public function actionSess(){
        var_dump(Yii::$app->session->get('ga/Captcha'));
    }

    public function actionTest(){

        $res = Yii::$app->request->post('captcha');
        $ca = new CaptchaValidator();

        if($res == null){
            return $this->render('captcha');
        }

        if($ca->validate($res)){
            echo "success";
        }else{
            echo "fail";
        }
    }
}
