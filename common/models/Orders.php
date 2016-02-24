<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property integer $room_id
 * @property string $email
 * @property string $message
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Orders extends \yii\db\ActiveRecord
{
    const ACTIVE = 1;
    const DISABLE = 0;
    const LIMIT = 7;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
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
            [['room_id', 'email', 'message'], 'required'],
            [['room_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string'],
            [['email'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'room_id' => 'Room ID',
            'email' => 'Email',
            'message' => 'Message',
            'status' => 'Статус',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param $status
     * @return mixed
     */
    public static function getStatuses($status)
    {
        $statuses = [
            self::ACTIVE => 'Обработана',
            self::DISABLE => 'Новая'
        ];
        return $statuses[$status];
    }

    /**
     * @param $id
     * @return string
     */
    public static function getRoomName($id)
    {
        $model = Rooms::findOne(['id' => $id]);
        return isset($model) ? $model->name : 'Не найдена запись с id #'.$id;
    }

    /**
     * @return int|string
     */
    public static function getNewOrders()
    {
        return self::find()->where(['status' => self::DISABLE])->count();
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNewOrdersList()
    {
        return static::find()->where(['status' => self::DISABLE])->limit(self::LIMIT)->asArray()->all();
    }
}
