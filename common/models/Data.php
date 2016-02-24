<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "data".
 *
 * @property integer $id
 * @property string $category
 * @property integer $priority
 * @property string $target
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 */
class Data extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'priority', 'data', 'created_at', 'updated_at'], 'required'],
            [['category', 'data'], 'string'],
            [['priority', 'created_at', 'updated_at'], 'integer'],
            [['target'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'category' => Yii::t('app', 'Category'),
            'priority' => Yii::t('app', 'Priority'),
            'target' => Yii::t('app', 'Target'),
            'data' => Yii::t('app', 'Data'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }
}
