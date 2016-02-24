<?php

/* @var $this yii\web\View */
/* @var $dataProvider @app\modules\models\Pages */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Установленные модули';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title"><?= $this->title?></h3>
                <div class="box-tools">
                    <div class="input-group" style="width: 150px;">
                        <input type="text" name="table_search" class="form-control input-sm pull-right" placeholder="Поиск" />
                        <div class="input-group-btn">
                            <button class="btn btn-sm btn-default"><i class="fa fa-search"></i></button>
                        </div>
                    </div>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <?php
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    'tableOptions' => ['class' => 'table table-hover overlay'],
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'name',
                            'header' => 'Название',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->active ? $model->name : Html::tag('s', $model->name);
                            },
                        ],
                        [
                            'attribute' => 'module',
                            'header' => 'module id',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->module;
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Активация',
                            'template' => '{update} ',
                            'buttons' => [
                                'update' => function($url, $model){
                                    $form = Html::beginForm(Url::to($url), 'post');
                                    $form .= Html::activeCheckbox($model, 'active', ['class' => 'minimal','label' => false]);
                                    $form .= Html::endForm();
                                    return $form;
                                },
                            ],
                        ],
                    ],
                ]);?>
            </div>
            <!-- Loading (remove the following to stop the loading)-->
            <div class="overlay ajax">
                <i class="fa fa-refresh fa-spin"></i>
            </div>
        </div>
    </div>
</div>
<?php $this->registerJs("$('input[type=\"checkbox\"].minimal').iCheck({ checkboxClass: 'icheckbox_minimal-blue' });
                         var AJAX = $('.ajax');
                         $('.iCheck-helper').click(function(){ $(this).closest('form').submit(); });");?>