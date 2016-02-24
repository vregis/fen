<?php

namespace backend\modules\price\controllers;

use Yii;
use yii\filters\AccessControl;
use backend\controllers\SiteController;
use common\models\Price;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class DefaultController extends SiteController
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'add', 'category', 'update', 'delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'category' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $query = Price::find();
        $queryType = Price::find();
        $queryCategory = Price::find();

        return $this->render('index', [
            'dataProvider' => $this->_findData($query->where('type_id IS NOT NULL')->andWhere('category_id IS NOT NULL')),
            'dataProviderType' => $this->_findData($queryType->where('type_id IS NULL')->andWhere('category_id IS NULL')),
            'dataProviderCategory' => $this->_findData($queryCategory->where('type_id IS NOT NULL')
                ->andWhere('category_id IS NULL'))
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionAdd()
    {
        $model = new Price();
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->save();
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        return $this->render('form', [
            'model' => new Price(),
            'new' => true,
        ]);
    }

    /**
     * @param $id
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        if(!$model = Price::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        if($model->load(Yii::$app->request->post()) && $model->validate()){
            $model->update();
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        return $this->render('form', ['model' => $model, 'new'=>false]);
    }

    /**
     *
     */
    public function actionCategory(){
        return $this->renderPartial('_categories',['model'=>new Price]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionDelete($id)
    {
        if(!$model = Price::findOne(['id' => $id])){
            throw new NotFoundHttpException('The requested page does not exist.');
        }elseif(Price::find()->where(['type_id'=>$id])->orWhere(['category_id'=>$id])->count()){
            \Yii::$app->getSession()->setFlash('error', 'Данная категория соделжит элементы, для начала вам необходимо удалить их.');
            return $this->redirect(Yii::$app->homeUrl.$this->module->id);
        }
        $model->delete();
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
        ]);
    }


}
