<?php

namespace backend\modules\imodules\controllers;

use Yii;
use backend\controllers\SiteController;
use yii\filters\AccessControl;
use backend\modules\imodules\models\Modules as MM;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;

class DefaultController extends SiteController
{
    const ACTIVE = 'true';
    const DISABLE = 'false';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'update'],
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
        return $this->render('index', [
            'dataProvider' => $this->_findData(MM::find())
        ]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$model = MM::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->update();
        }
        return $this->redirect(Yii::$app->homeUrl.$this->module->id);
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
                'forcePageParam' => false,
                'pageSizeParam' => false
            ])
        ]);
    }

}
