<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\jui\Sortable;
use yii\helpers\Url;
use common\models\GalleryImages;

/* @var $model common\models\Gallery */

$li = [];
foreach(GalleryImages::getImages($model->id) as $i){
    $li[] = ArrayHelper::getValue($i, function($image){
        if($image['id'] == 15){
            return [
                'content' => Html::img('@gallery/' . $image['basename'].'_thumb.'.$image['ext'],
                        [
                            'class' => $image['publish'] == 0 ? 'unpublished' : '',
                            'data-pos' => $image['pos'],
                            'data-id' => $image['id'],
                        ])
            ];
        }else{
            return [
                'content' => Html::img('@gallery/' . $image['basename'].'_thumb.'.$image['ext'],
                        [
                            'class' => $image['publish'] == 0 ? 'unpublished' : '',
                            'data-pos' => $image['pos'],
                            'data-id' => $image['id'],
                        ]) . '<div class="edit">
                            <i class="fa fa-fw fa-arrows"></i>
                            <i class="fa fa-fw fa-pencil" data-toggle="modal" href="#edit-image"></i>
                            <i class="fa fa-fw fa-trash" data-url="'. Url::toRoute(['image-delete', 'id' => $image['id']]) .'"></i>
                        </div>'
            ];
        }

    });
}?>
<div class="box-content">
    <div id="thumbs">
        <?php echo Sortable::widget([
            'items' => $li,
            'options' => ['tag' => 'ul', 'id' => 'sortable_widget', 'class' => 'ui-sortable'],
            'itemOptions' => ['tag' => 'li'],
            'clientOptions' => ['cursor' => 'move'],
            'clientEvents' => [
                'update' => 'function(){
                                var dataToServer = [];
                                $("#thumbs li img").each(function(c){
                                    $(this).attr("data-pos", (c));
                                    dataToServer[c] = $(this).attr("data-id");
                                });
                                $.post("/_root/gallery/update-positions", {values: dataToServer}, function(){
                                    $.jGrowl("Порядок изменён успешно!", { header: "Уведомление" });
                                });
                                }'
            ]
        ]);
        ?>
    </div>
</div>
<div class="clear"></div>