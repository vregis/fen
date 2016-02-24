<?php

namespace backend\components;

use Yii;
use yii\base\Action;
use yii\web\UploadedFile;
use common\models\GalleryImages;
use yii\imagine\Image;
use yii\helpers\FileHelper;

/**
 * Class Multiupload
 * @author Alexandr Krasnopyorov <sanya-sliver@yandex.ru>
 */

class Multiupload extends Action{

    /**
     * @var string
     * path_to_save
     */
    public $path;

    /**
     * @var integer
     * thumb_width
     */
    public $width = 70;

    /**
     * @var integer
     * thumb_height
     */
    public $height = 70;

    /**
     * @var integer
     * quality image
     */
    public $quality = 100;

    /**
     * @return bool
     * @throws \yii\base\Exception
     */
    public function run()
    {
        if (!file_exists($this->path)) FileHelper::createDirectory($this->path, 755, true);
        $image = new GalleryImages();
        $image->file = UploadedFile::getInstancesByName('file');
        //save to DB
        $image->gallery_cat_id = Yii::$app->request->post('id') ? Yii::$app->request->post('id') : GalleryImages::NOT_PARENT;
        $image->name = '';
        $image->alt = '';
        $image->title = '';
        $image->basename = $image->file[0]->baseName . '_' . time();
        $image->ext = $image->file[0]->extension;
        $image->publish = 1;
        $image->pos = 0;
        if($image->validate()){
            $image->file[0]->saveAs($this->path . $image->basename . '.' . $image->ext);
            //thumb
            Image::thumbnail($this->path . $image->basename . '.' . $image->ext, $this->width, $this->height)
                ->save($this->path . $image->basename . '_thumb.' . $image->ext, ['quality' => $this->quality]);
            return $image->save();
        }
    }
} 