<?php
namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class LoginAsset
 * Made for The Association of Crimean resorts
 * @author Alexandr Krasnopyorov <sanya-sliver@yandex.ru>
 */
class LoginAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/lte';
    public $css = [
        'css/AdminLTE.css',
        'css/font-awesome.min.css',
        'plugins/iCheck/square/blue.css',
        'css/override.css',
    ];
    public $js = [
        'plugins/iCheck/icheck.min.js',
        'js/icheck_bundle.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
