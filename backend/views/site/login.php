<?php
use backend\assets\LoginAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

LoginAsset::register($this);

$this->title = 'Вход в панель управления сайтом';
$this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="login-page">
    <?php $this->beginBody() ?>
        <div class="site-login">
            <div class="login-box">
                <div class="login-logo">
                    <b>Admin</b> light version 0.0.1
                </div><!-- /.login-logo -->
                <div class="login-box-body">
                    <p class="login-box-msg">Введите логин\пароль</p>

                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                        <?= $form->field($model, 'username', [
                            'inputTemplate' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-user form-control-feedback"></span></div>',
                        ]) ?>
                        <?= $form->field($model, 'password', [
                            'inputTemplate' => '<div class="form-group has-feedback">{input}<span class="glyphicon glyphicon-lock form-control-feedback"></span></div>',
                        ])->passwordInput() ?>
                        <?= $form->field($model, 'rememberMe')->checkbox() ?>
                        <?= Html::submitButton('Войти', ['class' => 'btn btn-primary login-button', 'name' => 'login-button']) ?>
                    <?php ActiveForm::end(); ?>

                </div><!-- /.login-box-body -->
            </div><!-- /.login-box -->
        </div>
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>