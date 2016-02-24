<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAsset
 * Made for The Association of Crimean resorts
 * @author Alexandr Krasnopyorov <sanya-sliver@yandex.ru>
 */
class CkEditorAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/lte/ckeditor';

    public $css = [
    ];

    public $js = [
        'ckeditor.js',
        'adapters/jquery.js'
    ];
    public $depends = [
        'backend\assets\AppAsset'
    ];
}
