<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Профиль пользователя «' . Yii::$app->user->identity->name . '»';
?>
<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title)?></h3>
                </div><!-- /.box-header -->
                <?php $form_user = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                <div class="box-body">
                    <?= Yii::$app->session->hasFlash('success') ? Html::tag('div', Yii::$app->session->getFlash('success'), ['class' => 'flash_message']) : ''?>
                    <?= $form_user->field($model, 'name') ?>
                    <?= $form_user->field($model, 'username') ?>
                    <?= $form_user->field($model, 'email') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>