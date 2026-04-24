<?php

namespace frontend\assets;

use yii\web\AssetBundle;

class VueAppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $js = [
        'dist/js/app.js',
    ];
    public $css = [
        'dist/css/app.css',
    ];
    public $jsOptions = [
        'type' => 'module',
    ];
    public $depends = [
        'yii\web\YiiAsset',
    ];
}
