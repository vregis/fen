<?php

/* @var $this yii\web\View */
/* @var $dataProvider common\models\Price */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;

$this->title = 'Список заявок на бронирование';
?>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <h3 class="box-title">Прайс сайта</h3>
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
                    'dataProvider' => $dataProviderType,
                    'summary' => false,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'name',
                            'header' => 'Название',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->name;
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
                echo GridView::widget([
                    'dataProvider' => $dataProviderCategory,
                    'summary' => false,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'type_id',
                            'header' => 'Раздел',
                            'value' => function ($model) {
                                return $model->type->name;
                            },
                            'format' => 'html'
                        ],
                        [
                            'attribute' => 'name',
                            'header' => 'Название',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->name;
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
                echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'summary' => false,
                    'tableOptions' => ['class' => 'table table-hover'],
                    'columns' => [
                        [
                            'attribute' => 'type_id',
                            'header' => 'Раздел',
                            'value' => function ($model) {
                                return $model->type->name;
                            },
                            'format' => 'html'
                        ],
                        [
                            'attribute' => 'category_id',
                            'header' => 'Категория',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->category->name;
                            },
                        ],
                        [
                            'attribute' => 'name',
                            'header' => 'Название',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->name;
                            },
                        ],
                        [
                            'attribute' => 'price',
                            'header' => 'Цена',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->price;
                            },
                        ],
                        [
                            'attribute' => 'time',
                            'header' => 'Время',
                            'format' => 'html',
                            'value' => function ($model) {
                                return $model->time;
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

                echo Html::tag('div', Html::a('Добавить', Url::toRoute(['/price/add']), ['class' => 'btn btn-block btn-primary']), [
                    'class' => 'button-add'
                ]);
                ?>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    window.onload = function(){
        <?php if(Yii::$app->session->getFlash('error')):?>
        alert('<?=Yii::$app->session->getFlash('error')?>' );
        <?php endif; ?>
    };
</script>