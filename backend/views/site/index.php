<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $email common\models\QuickEmail */
/* @var $this yii\web\View */

$this->title = 'Панель управления сайтом';
?>
<div class="row">
    <div class="col-md-12">
        <!-- TABLE: LATEST ORDERS -->
        <div class="box box-info">
            <!-- quick email widget -->
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-envelope"></i>
                    <h3 class="box-title">Быстро отправить Email</h3>
                </div>
                <div class="box-body">
                    <?= Yii::$app->session->hasFlash('success') ? Html::tag('div', Yii::$app->session->getFlash('success'), ['class' => 'flash_message']) : ''?>
                    <?php $form = ActiveForm::begin(['method' => 'post', 'action' => '', 'options' => ['role' => 'form']]); ?>
                    <?= $form->field($email,'email_to')->input('text', ['placeholder' => 'Кому'])->label(false)?>
                    <?= $form->field($email,'subject')->input('text', ['placeholder' => 'Тема сообщения'])->label(false)?>
                    <?= $form->field($email,'message')->textarea(['class' => 'textarea message', 'placeholder' => 'Сообщение'])->label(false)->error(false)?>
                    <div class="form-group">
                        <?= Html::submitButton('Отправить <i class="fa fa-arrow-circle-right"></i>', ['class' => 'pull-right btn btn-default']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->

</div>
<?php $this->registerCssFile(Url::toRoute('/lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css'));?>
<?php $this->registerJsFile(Url::toRoute('/lte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js'),['depends'=>'yii\web\JqueryAsset']);?>
<?php $this->registerJs('$(".textarea").wysihtml5();');?>