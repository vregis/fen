<?php
/**
 * Class UploadImageCkEditor
 * @author Alexandr Krasnopyorov <sanya-sliver@yandex.ru>
 */

namespace backend\components;

use Yii;
use yii\base\Action;
use yii\helpers\FileHelper;

/**
 * Class UploadImageCkEditor
 * @package backend\components
 */
class UploadImageCkEditor extends Action{

    /**
     * @var string
     */
    public $path;

    /**
     * @throws \yii\base\Exception
     */
    public function run()
    {
        if (!file_exists($this->path)) FileHelper::createDirectory($this->path, 755, true);
        $file = $this->path . basename(str_replace('.','-' . time() . '.',$_FILES['upload']['name']));

        if (move_uploaded_file($_FILES['upload']['tmp_name'], $file)) {
            $callback = $_REQUEST['CKEditorFuncNum'];
            $message = 'Загрузка прошла успешно:)\n';
            $file = str_replace($_SERVER['DOCUMENT_ROOT'].'/frontend/web','',$file);
            exit('<script type="text/javascript">window.parent.CKEDITOR.tools.callFunction("'.$callback.'", "'.$file.'", "'.$message.'" );</script>');
        } else {
            exit("Возможная атака с помощью файловой загрузки!\n");
        }
    }

} 