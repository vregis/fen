<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web/lte';
    public $css = [
        'css/AdminLTE.min.css',
        'https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css',
        'css/ionicons.min.css',
        'css/skins/_all-skins.min.css',
        'plugins/iCheck/all.css',
        'css/override.css',
        'plugins/select2/select2.min.css',
        //'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
        //'plugins/jvectormap/jquery-jvectormap-1.2.2.css',
    ];
    public $js = [
        'js/bootstrap.min.js',
        'plugins/slimScroll/jquery.slimscroll.min.js',
        'plugins/fastclick/fastclick.min.js',
        'plugins/iCheck/icheck.min.js',
        //'plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
        //'https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js',
        //'plugins/daterangepicker/daterangepicker.js',
        //'plugins/knob/jquery.knob.js',
        //'plugins/jvectormap/jquery-jvectormap-1.2.2.min.js',
        //'plugins/jvectormap/jquery-jvectormap-world-mill-en.js',
        //'plugins/sparkline/jquery.sparkline.min.js',
        'plugins/jQueryUI/jquery-ui.min.js',
        'js/app.js',
        //'js/demo.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
