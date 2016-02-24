<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use backend\assets\CkEditorAsset;

/* @var $this yii\web\View */
/* @var $model common\models\Orders */
/* @var $add Boolean */
CkEditorAsset::register($this);

$this->title = 'Добавление/Редактирование прайса';
?>

<div class="row">
    <div class="col-md-8">

        <div class="box">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><?= Html::encode($this->title)?></h3>
                </div><!-- /.box-header -->
                <?php
                if(!$new):
                if(NULL === $model->type_id &&  NULL === $model->category_id):?>
                    <div class="box-header with-border">
                        <h4 class="box-title">Редактирование раздела</h4>
                    </div>
                <div>
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                        <div class="box-body">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'priority')->textInput() ?>
                            <div class="form-group">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <?php elseif(NULL !== $model->type_id &&  NULL === $model->category_id):?>
                    <div class="box-header with-border">
                        <h4 class="box-title">Редактирование категории</h4>
                    </div>
                <div>
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                        <div class="box-body">
                            <?= $form->field($model, 'type_id')->dropDownList($model->getTypes(),['prompt'=>'']) ?>
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'priority')->textInput(['maxlength' => true]) ?>
                            <div class="form-group">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
                <?php else:?>
                <div>
                    <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                    <div class="box-header with-border">
                        <h4 class="box-title">Редактирование записи</h4>
                    </div>
                        <div class="box-body">
                            <?= $form->field($model, 'type_id')->dropDownList($model->getTypes(),['prompt'=>'','class'=>'type_change']) ?>
                            <?= $form->field($model, 'category_id')->dropDownList($model->getCategories($model->type_id),['class'=>'category_list form-control']) ?>
                            <?= $form->field($model, 'priority')->textInput() ?>
                            <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                            <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>
                            <div class="form-group">
                                <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                    <?php ActiveForm::end(); ?>
                </div>
            <?php endif;
                    else:?>
                        <div>
                            <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                            <div class="box-header with-border">
                                <h4 class="box-title">Добавление раздела</h4>
                            </div>
                            <div class="box-body">
                                <?= $form->field($model, 'priority')->textInput() ?>
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div>
                            <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                            <div class="box-header with-border">
                                <h4 class="box-title">Добавление категории</h4>
                            </div>
                            <div class="box-body">
                                <?= $form->field($model, 'type_id')->dropDownList($model->getTypes(),['prompt'=>'']) ?>
                                <?= $form->field($model, 'priority')->textInput() ?>
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
                        <div>
                            <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
                            <div class="box-header with-border">
                                <h4 class="box-title">Добавление записи</h4>
                            </div>
                            <div class="box-body">
                                <?= $form->field($model, 'type_id')->dropDownList($model->getTypes(),['prompt'=>'',
                                    'class'=>'form-control type_change']) ?>
                                <?= $form->field($model, 'category_id')->dropDownList([],['class'=>
                                    'form-control category_list']) ?>
                                <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'price')->textInput(['maxlength' => true]) ?>
                                <?= $form->field($model, 'time')->textInput(['maxlength' => true]) ?>
                                <div class="form-group">
                                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                                </div>
                            </div>
                            <?php ActiveForm::end(); ?>
                        </div>
            <?php endif;?>
            </div>
        </div>
    </div>
</div>
<?php $js = <<<JS
    $('.type_change').on('change',function(e){
    console.log($(this).val());
        $.ajax({
            url:'/_root/price/category',
            type:'POST',
            data: {type_id:$(this).val()},
            success:function(result){
            console.log(result);
                $('.category_list').replaceWith(result);
            }
        })
    });
JS;
$this->registerJs($js,\yii\web\View::POS_READY);
?>


<?php $this->registerJsFile(Url::toRoute('/lte/js/orders_bundle.js'),['depends'=>'yii\web\JqueryAsset']);?>