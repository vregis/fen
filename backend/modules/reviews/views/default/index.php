<?php

/* @var $this yii\web\View */
/* @var $dataProvider common\models\Reviews */

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\Reviews;

$this->title = 'Список новостей';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список отзывов представлен ниже</h3>
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
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'name',
                            'header' => 'Имя',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->publish ? $model->name : Html::tag('s', $model->name);
                            },
                        ],
                        'email',
                        [
                            'attribute' => 'publish',
                            'header' => 'Публикация',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Reviews::getStatusesIcon($model->publish);
                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'header' => 'Создан',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->created_at);
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'header' => 'Обновлён',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asRelativeTime($model->updated_at);
                            },
                        ],
                        [
                            'attribute' => 'module_id',
                            'header' => 'Модуль',
                            'format' => 'html',
                            'value' => function ($model) {
                                return Reviews::getModuleName($model->module_id);
                            },
                        ],
                        [
                            'class' => 'yii\grid\ActionColumn',
                            'header' => 'Редактирование',
                            'template' => '{update} {delete}',
                            'buttons' => [
                                'update' => function($url){
                                    return Html::a('<i class="fa fa-fw fa-pencil"></i>', $url);
                                },
                                'delete' => function($url){
                                    return Html::a('<i class="fa fa-fw fa-remove"></i>', $url, [
                                        'data' => [
                                            'confirm' => 'Вы уверены, что хотите удалить?',
                                            'method' => 'post',
                                        ]]);
                                }
                            ],
                        ],
                    ],
                ]);
                ?>
            </div>
        </div>
    </div>
</div>