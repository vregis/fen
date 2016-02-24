<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "gallery_images".
 *
 * @property integer $id
 * @property integer $gallery_cat_id
 * @property string $name
 * @property string $alt
 * @property string $title
 * @property string $basename
 * @property string $ext
 * @property integer $publish
 * @property integer $pos
 */
class GalleryImages extends \yii\db\ActiveRecord
{

    const NOT_PARENT = 0;

    /**
     * @var yii/web/UploadedFile file attribute
     */
    public $file;

    const PATH = '/frontend/web/userfiles/gallery/';
    const PATHSHOW = '/userfiles/gallery/';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'gallery_images';
    }

    public function behaviors()
    {
        return [
            [
                'class' => \maxmirazh33\image\Behavior::className(),
                'savePathAlias' => '@web/images/',
                'urlPrefix' => '/images/',
                'crop' => true,
                'attributes' => [
                    'file' => [
                        'savePathAlias' => '@web/images/avatars/',
                        'urlPrefix' => '/images/avatars/',
                        'width' => 100,
                        'height' => 100,
                    ],
                    'logo' => [
                        'crop' => false,
                        'thumbnails' => [
                            'mini' => [
                                'width' => 50,
                            ],
                        ],
                    ],
                ],
            ],
            //other behaviors
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['gallery_cat_id', 'basename', 'ext'], 'required'],
            [['gallery_cat_id', 'publish', 'pos'], 'integer'],
            [['name', 'alt', 'title', 'basename', 'ext'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'gallery_cat_id' => 'Gallery Cat ID',
            'name' => 'Название',
            'alt' => 'Alt',
            'title' => 'Title',
            'basename' => 'Basename',
            'ext' => 'Ext',
            'publish' => 'Публикация',
            'pos' => 'Pos',
        ];
    }

    /**
     * @param $gallery_cat_id
     * @return int
     */
    public static function saveGalleryCatId($gallery_cat_id)
    {
        return GalleryImages::updateAll(['gallery_cat_id' => $gallery_cat_id],['gallery_cat_id' => self::NOT_PARENT]);

    }

    /**
     * @param $gallery_cat_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getImages($gallery_cat_id)
    {
        return GalleryImages::findByCondition(['gallery_cat_id' => $gallery_cat_id])
            ->orderBy('pos')
            ->all();
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            unlink($_SERVER['DOCUMENT_ROOT'].GalleryImages::PATH . $this->basename . '.'. $this->ext);
            unlink($_SERVER['DOCUMENT_ROOT'].GalleryImages::PATH . $this->basename . '_thumb.'. $this->ext);
            return true;
        } else {
            return false;
        }
    }
}
