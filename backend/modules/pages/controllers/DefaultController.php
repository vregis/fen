<?php

namespace backend\modules\pages\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\controllers\SiteController;
use common\models\Pages;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DefaultController extends SiteController
{

    const PAGE_SIZE = 25;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'update', 'delete', 'update-pos', 'childs'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'update-pos' => ['post'],
                    'childs' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Pages::find()->where(['parent_id' => 0])->orderBy(['pos' => SORT_ASC]);
        return $this->render('index', [
            'dataProvider' => $this->_findData($query)
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Pages();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        return $this->render('form', [
            'model' => new Pages()
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$model = Pages::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->update();
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        return $this->render('form', ['model' => $model]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if(!$model = Pages::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();
        return $this->redirect(Yii::$app->homeUrl.$this->module->id);
    }

    public function actionUpdatePos()
    {
        foreach(Yii::$app->request->post('data') as $key => $value){
            $gallery = Pages::findOne(['id' => $value]);
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
        return $this->renderAjax('_pages_childs', [
            'dataProvider' => $this->_findData(Pages::find()->where(['parent_id' => $id])->orderBy(['pos' => SORT_ASC])),
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
            'pagination' => new Pagination([
                'pageSize' => self::PAGE_SIZE,
                'forcePageParam' => false,
                'pageSizeParam' => false
            ])
        ]);
    }
}
