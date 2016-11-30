<?php

namespace app\controllers;

use app\models\UploadModel;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{


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
//            'dropzone' => [
//                'class' => 'app\models\DropzoneAction'
//            ]
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
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
}
