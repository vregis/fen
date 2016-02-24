<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\CkEditorAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
CkEditorAsset::register($this);

$this->title = 'Добавление/Редактирование заявки на бронирование';
?>

<div class="row">
    <div class="col-md-8">

        <div class="box">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title)?></h3>
                </div><!-- /.box-header -->
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                        <div class="box-body">
                            <?= $form->field($model, 'target')->hiddenInput()->label(false) ?>
                            <?= $form->field($model, 'data')->label('Ссылка'); ?>
                            <div class="form-group">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile(Url::toRoute('/lte/js/orders_bundle.js'),['depends'=>'yii\web\JqueryAsset']);?>