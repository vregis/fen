<?php

namespace backend\modules\gallery\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\controllers\SiteController;
use common\models\Gallery;
use common\models\GalleryImages;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

class DefaultController extends SiteController
{
    /**
     * @return array
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'update', 'delete', 'multiupload', 'load-images', 'update-positions', 'image-edit', 'image-delete', 'update-gallery-pos', 'childs'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'multiupload' => ['post'],
                    'update-positions' => ['post'],
                    'image-edit' => ['post'],
                    'image-delete' => ['post'],
                    'update-gallery-pos' => ['post'],
                    'load-images' => ['post'],
                    'childs' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return array
     */
    public function actions()
    {
        return [
            'multiupload' => [
                'class' => 'backend\components\Multiupload',
                'path' => $_SERVER['DOCUMENT_ROOT'].GalleryImages::PATH,
                'width' => 1420,
                'height' => 600,
                'quality' => 100,
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Gallery::find()->where(['parent_id' => 0])->andWhere('news_id IS NULL')->orderBy(['pos' => SORT_ASC]);
        return $this->render('index', [
            'dataProvider' => $this->_findData($query)
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Gallery();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            GalleryImages::saveGalleryCatId($model->id);
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }

        return $this->render('form', [
            'model' => new Gallery(),
            'images' => new GalleryImages()
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$model = Gallery::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }

        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        return $this->render('form', ['model' => $model, 'images' => new GalleryImages()]);
    }

    public function actionUpdatePositions()
    {
        foreach(Yii::$app->request->post('values') as $key => $value)
        {
            $image = GalleryImages::findOne(['id' => $value]);
            $image->pos = $key;
            $image->update();
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionImageEdit($id)
    {
        $model = GalleryImages::findOne(['id' => $id]);
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->update();
            return Json::encode($this->renderAjax('blocks/_image_box', ['model' => Gallery::findOne(['id' => $model->gallery_cat_id])]));
        }
        return $this->renderAjax('blocks/_image_edit', ['model' => $model]);

    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if(!$model = Gallery::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        GalleryImages::deleteAll(['gallery_cat_id' => $id]);
        $model->delete();
        return $this->redirect(Yii::$app->homeUrl.$this->module->id);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionLoadImages($id)
    {
        if(!$id){
            return '';
        }
        return $this->renderAjax('blocks/_image_box', ['model' => Gallery::findOne(['id' => $id])]);
    }

    /**
     * @param $id
     * @return false|int
     */
    public function actionImageDelete($id)
    {
        $image = GalleryImages::findOne(['id' => $id]);
        return $image->delete();
    }

    public function actionUpdateGalleryPos()
    {
        foreach(Yii::$app->request->post('data') as $key => $value){
            $gallery = Gallery::findOne(['id' => $value]);
            $gallery->pos = $key;
            $gallery->update();
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionChilds($id)
    {
        return $this->renderAjax('blocks/_gallery_childs', [
            'dataProvider' => $this->_findData(Gallery::find()->where(['parent_id' => $id])->orderBy(['pos' => SORT_ASC])),
            'parent_id' => $id
        ]);
    }

    /**
     * @param $query
     * @return ActiveDataProvider
     */
    private function _findData($query)
    {
        return new ActiveDataProvider([
            'query' => $query,
            'sort' => false,
            'pagination' => false
        ]);
    }

}
