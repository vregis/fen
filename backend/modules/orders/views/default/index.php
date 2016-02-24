<?php

/* @var $this yii\web\View */
/* @var $dataProvider common\models\Orders */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use common\models\Orders;

$this->title = 'Список заявок на бронирование';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Список заявок на бронирование</h3>
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
                            'attribute' => 'room_id',
                            'header' => 'Номер',
                            'value' => function ($model) {
                                return Orders::getRoomName($model->room_id);
                            },
                            'format' => 'html'
                        ],
                        [
                            'attribute' => 'publish',
                            'header' => 'Статус',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->status == 0
                                    ? Html::tag('span', Orders::getStatuses($model->status), ['class' => 'label label-info'])
                                    : Html::tag('span', Orders::getStatuses($model->status), ['class' => 'label label-success']);
                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'header' => 'Создана',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asDate($model->created_at);
                            },
                        ],
                        [
                            'attribute' => 'updated_at',
                            'header' => 'Обновлена',
                            'value' => function ($model) {
                                return Yii::$app->formatter->asRelativeTime($model->updated_at);
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