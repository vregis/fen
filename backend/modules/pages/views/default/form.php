<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use common\models\Pages;
use backend\assets\CkEditorAsset;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Pages */
CkEditorAsset::register($this);

$this->title = 'Добавление/Редактирование страницы';
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
                    <?php if(($parent_id = Yii::$app->request->post('parent_id')) !== null){
                        echo $form->field($model, 'parent_id')->hiddenInput(['value' => $parent_id])->label(false);
                    } else {
                        ArrayHelper::remove(Pages::$pages,$model->id);
                        //echo $form->field($model, 'parent_id')->dropDownList(Pages::$pages, ['class' => 'form-control select2']);
                    }?>
                    <?= $form->field($model, 'name') ?>
                    <?= $form->field($model, 'title') ?>
                    <?= $form->field($model, 'description') ?>
                    <?= $form->field($model, 'keywords') ?>
                    <?= $form->field($model, 'alias') ?>
                    <?= $form->field($model, 'text')->textarea() ?>
                    <?php if(!$model->isNewRecord):?>
                        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal']) ?>
                    <?php endif;?>
                    <?= $form->field($model, 'pos') ?>
                    <div class="form-group">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJsFile(Url::toRoute('/lte/plugins/select2/select2.full.min.js'),['depends'=>'backend\assets\AppAsset']);?>
<?php $this->registerJsFile(Url::toRoute('/lte/js/pages_bundle.js'),['depends'=>'yii\web\JqueryAsset']);?>