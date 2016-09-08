<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        '/libs/bootstrap/css/bootstrap.min.css',
        '/libs/sir-trevor/sir-trevor.min.css',
        //'/libs/nice-tree/css/easyTree.css',
        '/libs/mbd/css/mdb.min.css',
        '/css/site.css',
        '/css/extended.css',
    ];
    public $js = [
        '/libs/jquery/jquery.min.js',
        '/libs/bootstrap/js/bootstrap.min.js',
        '/libs/mbd/js/mdb.min.js',
        '/js/formManager.js',
    ];
    public $depends = [
        //'yii\web\YiiAsset',
    ];
}
