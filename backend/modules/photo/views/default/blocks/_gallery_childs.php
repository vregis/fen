<?php

use yii\grid\GridView;
use common\models\Gallery;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $dataProvider @common\models\Gallery */
/* @var $parent_id @common\models\Gallery */
?>

<div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Список дочерних галерей</h4>
    </div>
    <div class="modal-body">
    <div class="row">
    <div class="col-lg-12 form-edit">
    <div class="box-body">
    <?php echo GridView::widget([
                'dataProvider' => $dataProvider,
                'summary' => false,
                'tableOptions' => ['class' => 'table table-hover'],
                'id' => 'child_box',
                'rowOptions' => function($model){
                    return [
                        'id' => $model['id']
                    ];
                },
                'columns' => [
                    'id',
                    [
                        'attribute' => 'name',
                        'header' => 'Название галереи',
                        'format' => 'html',
                        'value' => function ($model) {
                            return $model->publish ? $model->name : Html::tag('s', $model->name);
                        },
                    ],
                    [
                        'attribute' => 'publish',
                        'header' => 'Публикация',
                        'format' => 'html',
                        'value' => function ($model) {
                            return Gallery::getStatusesIcon($model->publish);
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
            ]);?>
        <div class="modal-footer">
            <?= Html::beginForm(Url::toRoute(['/gallery/add']), 'post', ['class' => 'child-add']) ?>
                <?= Html::input('hidden', 'parent_id', $parent_id) ?>
                <?= Html::submitButton('Добавить', ['class' => 'btn btn-block btn-primary button-add']) ?>
            <?= Html::endForm() ?>
            <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /.modal-content -->
</div>
    <!-- /.modal-dialog -->
<?php $this->registerCssFile(Url::toRoute('/lte/css/jquery.jgrowl.min.css'));?>
<?php $this->registerJsFile(Url::toRoute('/lte/js/jquery.jgrowl.min.js'),['depends'=>'yii\web\JqueryAsset']);?>
<?php $this->registerJs('$("#child_box .table-hover tbody").sortable({revert: true,items: "tr", cursor: "move", stop: function(event, ui) {
                            $.post("gallery/update-gallery-pos",{data:$("#child_box .table-hover tbody").sortable("toArray")});
                            $.jGrowl("Порядок изменён успешно!", { header: "Уведомление" });
                        }});');?>