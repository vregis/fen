<?php

namespace backend\modules\orders\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\controllers\SiteController;
use common\models\Orders;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

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
                        'actions' => ['index', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Orders::find();
        return $this->render('index', [
            'dataProvider' => $this->_findData($query)
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if (!$model = Orders::findOne(['id' => $id])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $this->_loadData($model);
        return $this->render('form', ['model' => $model]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if (!$model = Orders::findOne(['id' => $id])) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        $model->delete();
        return $this->redirect(Yii::$app->homeUrl . $this->module->id);
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

    /**
     * @param $model
     * @return \yii\web\Response
     */
    private function _loadData($model)
    {
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->save();
            return $this->redirect(Yii::$app->homeUrl . $this->module->id);
        }
    }
}
