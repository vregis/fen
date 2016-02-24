<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "gallery".
 *
 * @property integer $id
 * @property integer $news_id
 * @property integer $parent_id
 * @property string $name
 * @property integer $publish
 * @property integer $pos
 * @property integer $created_at
 * @property integer $updated_at
 */
class Gallery extends \yii\db\ActiveRecord
{

    const PUBLISH = 1;
    const UNPUBLISHED = 0;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id','news_id', 'publish', 'pos', 'created_at', 'updated_at'], 'integer'],
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'Новость',
            'parent_id' => 'Родительская галерея',
            'name' => 'Название галереи',
            'publish' => 'Публикация',
            'pos' => 'Pos',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена',
        ];
    }

    /**
     * @param $status
     * @return mixed
     */
    public static function getStatusesIcon($status)
    {
        $statuses = [
            self::UNPUBLISHED => '<i class="fa fa-fw fa-close"></i>',
            self::PUBLISH => '<i class="fa fa-fw fa-check"></i>'
        ];
        return $statuses[$status];
    }

    /**
     * @param $id
     * @return array
     */
    public static function getListGallery($id)
    {

        if($id){
            $model = static::find()->select('id, name')->where('id != :id', [':id' => $id])->andWhere(['parent_id' => 0])->all();
        } else {
            $model = static::find()->select('id, name')->where(['parent_id' => 0])->all();
        }
        return ArrayHelper::map(ArrayHelper::merge([['id' => '0', 'name' => 'Не выбрано']],$model), 'id', 'name');
    }

    /**
     * @param $id
     * @return $this
     */
    public static function existsChilds($id)
    {
        return static::find()->where(['parent_id' => $id])->count() > 0 ? true : false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(GalleryImages::className(), ['gallery_cat_id' => 'id']);
    }
}
