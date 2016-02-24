<?php
namespace backend\components;

use Yii;
use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * Class FileBehavior
 * @package backend\components
 */
class FileBehavior extends Behavior
{
    /**
     *
     */
    const SEPARATOR = 'web';
    /**
     * path_to_save_image
     */
    public $path;

    /**
     * @var
     */
    public $entity;

    /**
     * @var
     */
    private $_attribute;

    /**
     * @param \yii\base\Component $owner
     */
    public function attach($owner)
    {
        parent::attach($owner);
        $owner->on(ActiveRecord::EVENT_BEFORE_INSERT, [$this, 'onBeforeSave']);
        $owner->on(ActiveRecord::EVENT_BEFORE_UPDATE, [$this, 'onBeforeSave']);
        $owner->on(ActiveRecord::EVENT_BEFORE_DELETE, [$this, 'onBeforeDelete']);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function onBeforeSave()
    {
        $makePath = $this->getFileDir();
        if (!file_exists($makePath)) { FileHelper::createDirectory($makePath, 755, true); }
        if($this->_attribute = UploadedFile::getInstance($this->owner, 'file')){
            $image = $this->_attribute->baseName . '-' . time() . '.' . $this->_attribute->extension;
            $this->_attribute->saveAs($makePath.$image);
            $this->owner->{$this->entity} = $image;
        }
    }

    public function onBeforeDelete()
    {
        if($this->owner->{$this->entity}){
            unlink($this->getFileDir() . $this->owner->{$this->entity});
        }
    }

    /**
     * @return bool|string
     */
    public function getFileDir()
    {
        return Yii::getAlias('@frontend/' . self::SEPARATOR . $this->path);
    }

}