<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= Html::dropDownList('Price[category_id]','',$model->getCategories(Yii::$app->request->post('type_id')),
    ['class'=>'form-control category_list']); ?>

