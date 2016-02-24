<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use backend\components\FileBehavior;

/**
 * This is the model class for table "actions".
 *
 * @property integer $id
 * @property string $alias
 * @property string $image
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
class Actions extends \yii\db\ActiveRecord
{

    const PUBLISH = 1;
    const UNPUBLISHED = 0;

    const PATH = '/userfiles/actions/';
    const IMAGE_ENTITY = 'image';

    public $file;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'actions';
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
            [
                'class' => FileBehavior::className(),
                'path' => self::PATH,
                'entity' => self::IMAGE_ENTITY
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['alias', 'name', 'text', 'title', 'description', 'keywords'], 'required'],
            [['image', 'text', 'title', 'description', 'keywords'], 'string'],
            [['publish', 'pos', 'created_at', 'updated_at'], 'integer'],
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
            'image' => 'Изображение',
            'file' => 'Изображение',
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
}
