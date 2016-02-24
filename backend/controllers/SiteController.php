<?php
namespace backend\controllers;

use common\models\QuickEmail;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'upload-image-ckeditor', 'profile'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'upload-image-ckeditor' => [
                'class' => 'backend\components\UploadImageCkEditor',
                'path' => dirname(dirname(__DIR__)) . '/frontend/web/userfiles/ckeditor_upload/'
            ]
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $email = new QuickEmail();
        if(Yii::$app->request->post()){
            $this->_sendEmail($email);
        }
        return $this->render('index', [
            'email' => $email,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $this->layout = false;
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function actionProfile()
    {
        $model = User::getDb()->cache(function ($db) {
            return User::findOne(['id' => 1]);
        });

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->update();
            Yii::$app->session->setFlash('success', 'Сохранено успешно');
        }

        return $this->render('profile', [
            'model' => $model
        ]);
    }

    /**
     * @param $email
     */
    private function _sendEmail($email)
    {
        if ($email->load(Yii::$app->request->post()) && $email->validate()) {
            $email->sendEmail(Yii::$app->user->identity->email);
            Yii::$app->session->setFlash('success', 'Сообщение отправлено!');
        } else {
            Yii::$app->session->setFlash('success', 'Возникла ошибка при отправке сообщения:(');
        }
    }
}
