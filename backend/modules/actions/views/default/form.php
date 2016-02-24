<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\CkEditorAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Actions */
CkEditorAsset::register($this);

$this->title = 'Добавление/Редактирование новости';
?>

<div class="row">
    <div class="col-md-8">

        <div class="box">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title)?></h3>
                </div><!-- /.box-header -->
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form', 'enctype' => 'multipart/form-data']]); ?>
                        <div class="box-body">
                            <?= $form->field($model, 'name') ?>
                            <?= $form->field($model, 'title') ?>
                            <?= $form->field($model, 'description') ?>
                            <?= $form->field($model, 'keywords') ?>
                            <?= $form->field($model, 'alias') ?>
                            <?php if($model->image){?>
                                <?= Html::img('@actions/'.$model->image, ['alt' => $model->name, 'width' => '150']) ?>
                            <?php } ?>
                            <?= $form->field($model, 'file')->fileInput() ?>
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
<?php $this->registerJsFile(Url::toRoute('/lte/js/actions_bundle.js'),['depends'=>'yii\web\JqueryAsset']);?>