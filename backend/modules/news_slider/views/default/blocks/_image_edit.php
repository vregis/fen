<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/* @var $image common\models\GalleryImages */
?>
<div class="modal-dialog">
    <div class="modal-content">
        <?php $form = ActiveForm::begin(['method' => 'post', 'options' => ['role' => 'form']]); ?>
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Редактирование информации об изображении</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 form-edit">
                    <div class="box-body">
                        <?= $form->field($model, 'name') ?>
                        <?= $form->field($model, 'alt') ?>
                        <?= $form->field($model, 'title') ?>
                        <?= $form->field($model, 'publish')->checkbox(['class' => 'minimal'], false)->error(false) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
            <?= Html::submitButton('Сохранить', ['class' => 'btn btn-blue', 'id' => 'edit_image_button']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- /.modal-content -->
</div>
<!-- /.modal-dialog -->