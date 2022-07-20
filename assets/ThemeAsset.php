<?php

namespace rabint\theme\adminlte\assets;

use yii\web\AssetBundle;

class ThemeAsset extends AssetBundle {

//        public $publishOptions = ['forceCopy' => true];
    public $sourcePath = '@vendor/rabint/theme-adminlte/web';
    public $css = [
        'css/style.css'
    ];
    public $js = [
        'js/app.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'rabint\theme\adminlte\assets\AdminLte',
        'rabint\assets\Html5shiv',
        'rabint\assets\CommonAsset',
    ];

    public function init() {
        if (\rabint\locality::langDir() == 'rtl') {
            $this->depends [] = '\rabint\assets\BootstrapRtlAsset';
            $this->css [] = 'css/rtl_override.css';
        }
    }

}
