<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property integer $id
 * @property string $module_id
 * @property string $name
 * @property string $email
 * @property string $text
 * @property integer $publish
 * @property integer $created_at
 * @property integer $updated_at
 */
class Reviews extends \yii\db\ActiveRecord
{

    const PUBLISH = 1;
    const UNPUBLISHED = 0;
    const LIMIT = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reviews';
    }

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
    public function rules()
    {
        return [
            [['module_id', 'name', 'email', 'text'], 'required'],
            [['text'], 'string'],
            [['publish', 'created_at', 'updated_at'], 'integer'],
            [['module_id', 'name', 'email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'module_id' => 'Module ID',
            'name' => 'Имя',
            'email' => 'Email',
            'text' => 'Текст отзыва',
            'publish' => 'Публикация',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
     * @return string
     */
    public static function getModuleName($id)
    {
        $model = Modules::findOne(['module' => $id]);
        return $model->name;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getNewReviews()
    {
        return static::find()->where(['publish' => self::UNPUBLISHED])->count();
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public static function getNewReviewsList()
    {
        return static::find()->where(['publish' => self::UNPUBLISHED])->limit(self::LIMIT)->asArray()->all();
    }
}
