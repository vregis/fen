<?php

namespace common\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "price".
 *
 * @property integer $id
 * @property integer $type_id
 * @property integer $category_id
 * @property string $priority
 * @property string $name
 * @property string $price
 * @property string $time
 *
 * @property Price $type
 * @property Price[] $prices
 * @property Price $category
 * @property Price[] $prices0
 */
class Price extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type_id', 'category_id','priority'], 'integer'],
            [['name'], 'required'],
            [['name','price'], 'string', 'max' => 50],
            [['time'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type_id' => 'Раздел',
            'category_id' => 'Категория',
            'priority' => 'Приоритет',
            'name' => 'Название',
            'price' => 'Цена',
            'time' => 'Время',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getType()
    {
        return $this->hasOne(Price::className(), ['id' => 'type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices()
    {
        return $this->hasMany(Price::className(), ['type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Price::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrices0()
    {
        return $this->hasMany(Price::className(), ['category_id' => 'id']);
    }

    /**
     *
     */
    public function getTypes(){
        return ArrayHelper::map($this->find()->where('type_id IS NULL')->all(),'id','name');
    }
    /**
     *
     */
    public function getCategories($_iTypeId){
        return ArrayHelper::map($this::find()->where(['type_id'=>$_iTypeId])
            ->andWhere('category_id IS NULL')->all(),'id','name');
    }
}
