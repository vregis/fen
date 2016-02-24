<?php
namespace frontend\controllers;

use common\models\Actions;
use common\models\Data;
use common\models\Gallery;
use common\models\GalleryImages;
use common\models\News;
use common\models\Pages;
use common\models\Price;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;
use yii\rest\Action;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        $aContact  = ArrayHelper::map(Data::find()->where(['category'=>'contact'])->all(),'target','data');
        $aaAdvantages = Data::find()->where(['category'=>'advantages'])->all();
        $aSocial = ArrayHelper::map(Data::find()->where(['category'=>'social'])->all(),'target','data');
        $aaNews  = News::find()->all();//!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!1
        $aaPriceType = Price::find()->where('type_id IS NULL')->all();
        $aaPriceCategory = Price::find()->where('type_id IS NOT NULL')->andWhere('category_id IS NULL')
            ->orderBy(['priority'=>SORT_ASC])->all();
        $aaPrice = Price::find()->select(['category_id','name','price','time'])->where('type_id IS NOT NULL')
            ->andWhere('category_id IS NOT NULL')->all();
        $aPage   = Pages::find()->where(['alias'=>'/'])->one();
        $aAction = ArrayHelper::map(Actions::find()->select(['alias','text'])->all(),'alias','text');
        $oSlider = Gallery::find()->where(['id'=>'2'])->one();
        $aSlider = $oSlider->images;

        return $this->render('index',compact('aContact','aaAdvantages','aSocial','aaNews','aaPriceType',
            'aaPriceCategory','aaPrice','aPage','aAction','aSlider'));
    }

    public function actionMessage(){
        $aData = Yii::$app->request->post();

        $to      = 'great@mail.ru';
        $subject = 'Заказ услуги';
        $headers = 'From: sale@podfenom.granat.in' . "\r\n"
            .  "MIME-Version: 1.0" . "\r\n"
            . 'Content-type: text/html; charset=UTF-8' . "\r\n";

        $sHtml = '<p>Имя: ' . htmlspecialchars($aData['name']) . '</p>' .
            '<p>Фамилия: ' . htmlspecialchars($aData['sername']) . '</p>' .
            '<p>Услуга: ' . htmlspecialchars($aData['servise']) . '</p>' .
            '<p>Время: ' . htmlspecialchars($aData['time']) . '</p>';
        $sHtml .=  $aData['text']?'<p>Дополнительно: ' . htmlspecialchars($aData['text']) . '</p>':'';

        if( mail($to, $subject, $sHtml, $headers) ) Yii::$app->getSession()->setFlash('mail','Спасибо! Ваша заявка принята.');
        else Yii::$app->getSession()->setFlash('mail','К сожалению в данный момент мы не смогли приня вашу запись, '
            . 'приносим наши извенения.');

        $this->redirect('/');
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
