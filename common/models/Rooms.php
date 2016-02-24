<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\components\DropDownTreeBehavior;

/**
 * This is the model class for table "rooms".
 *
 * @property integer $id
 * @property integer $parent_id
 * @property integer $gallery_cat_id
 * @property string $alias
 * @property string $name
 * @property string $text
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property integer $publish
 * @property integer $pos
 * @property integer $created_at
 * @property integer $updated_at
 */
class Rooms extends \yii\db\ActiveRecord
{

    const PUBLISH = 1;
    const UNPUBLISHED = 0;

    /**
     * @var
     */
    public static $galleries;

    /**
     * @var
     */
    public static $rooms;

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => DropDownTreeBehavior::className()
            ]
        ];
    }

    /**
     *
     */
    public function init()
    {
        self::$galleries = $this->getTree(Gallery::find()->asArray()->all());
        self::$rooms = $this->getTree(Rooms::find()->asArray()->all());
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rooms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'gallery_cat_id', 'publish', 'pos', 'created_at', 'updated_at'], 'integer'],
            [['alias', 'name', 'text', 'title', 'description', 'keywords'], 'required'],
            [['text', 'title', 'description', 'keywords'], 'string'],
            [['alias', 'name'], 'string', 'max' => 255],
            ['pos', 'default', 'value' => 0],
            ['alias', 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Родитель',
            'gallery_cat_id' => 'Галерея',
            'alias' => 'Alias',
            'name' => 'Название',
            'text' => 'Текст',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'publish' => 'Публикация',
            'pos' => 'Позиция',
            'created_at' => 'Создана',
            'updated_at' => 'Обновлена'
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
     * @return $this
     */
    public static function existsChilds($id)
    {
        return static::find()->where(['parent_id' => $id])->count() > 0 ? true : false;
    }

}
