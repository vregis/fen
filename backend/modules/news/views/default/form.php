<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\CkEditorAsset;

/* @var $this yii\web\View */
/* @var $model common\models\News */
CkEditorAsset::register($this);

$this->title = 'Добавление/Редактирование новости';
?>

<div class="row">
    <div class="col-md-8">

        <div class="box">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title)?></h3> <br/><br/>
                    <?php $id = \common\models\Gallery::find()->where(['news_id' => $model->id])->one()?>
                    <?php if($id):?>
                        <?php if(!$model->isNewRecord):?>
                        <a class="btn btn-primary" href='/_root/news_slider/update/<?php echo $id->id?>'>Перейти к слайдеру</a>
                        <?php endif;?>
                    <?php endif;?>
                </div><!-- /.box-header -->
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form', 'enctype' => 'multipart/form-data']]); ?>
                        <div class="box-body">
                            <?= $form->field($model, 'name') ?>
                            <?= $form->field($model, 'alias')->hiddenInput(['value' => time()]) ?>
                            <?php if($model->image){?>
                                <?= Html::img('@news/'.$model->image, ['alt' => $model->name, 'width' => '150']) ?>
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
<?php $this->registerJsFile(Url::toRoute('/lte/js/news_bundle.js'),['depends'=>'yii\web\JqueryAsset']);?>