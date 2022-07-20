<?php

use rabint\theme\adminlte\widgets\Menu;
use app\models\TimelineEvent;

$ModuleMenu = [];
$modules = include (Yii::getAlias('@config/modules.php'));
foreach ((array) $modules as $item) {
    $moduleClass = $item['class'];
    if (method_exists($moduleClass, 'adminMenu')) {
        $ModuleMenu[] = call_user_func([$moduleClass, 'adminMenu']);
    }
//    $config = substr($moduleClass, 0, strrpos($moduleClass, '\\'));
//    $config .= '\Config';
//    if (class_exists($config)) {
//        $C = new $config;
//        if (method_exists($C, 'adminMenu')) {
//            $ModuleMenu[] = $C->adminMenu();
//        }
//    }
}
/* =================================================================== */
$TopMenu = [
        [
        'label' => Yii::t('rabint', 'پیشخوان'),
        'icon' => '<i class="fa fa-dashboard"></i>',
        'url' => ['/admin/index'],
    ],
        [
        'label' => Yii::t('rabint', 'محتوا'),
        'options' => ['class' => 'header']
    ],
        [
        'label' => Yii::t('rabint', 'محتوای ایستا'),
        'icon' => '<i class="fa fa-file-text"></i>',
        'url' => ['/admin-page/index'],
    ],
//    [
//        'label' => Yii::t('rabint', 'Content'),
//        'url' => '#',
//        'icon' => '<i class="fa fa-edit"></i>',
//        'options' => ['class' => 'treeview'],
//        'items' => [
//            [
//                'label' => Yii::t('rabint', 'محتوای ایستا'),
//                'icon' => '<i class="fa fa fa-circle-o"></i>',
//                'url' => ['/page/index'],
//            ],
//            ['label' => Yii::t('rabint', 'Articles'), 'url' => ['/article/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//            ['label' => Yii::t('rabint', 'Article Categories'), 'url' => ['/article-category/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//            ['label' => Yii::t('rabint', 'Text Widgets'), 'url' => ['/widget-text/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//            ['label' => Yii::t('rabint', 'Menu Widgets'), 'url' => ['/widget-menu/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//            ['label' => Yii::t('rabint', 'Carousel Widgets'), 'url' => ['/widget-carousel/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//        ]
//    ],
];
$optionItems = [];
foreach (app\models\Option::tabs() as $opt => $data) {
    $optionItems[] = ['label' => $data['title'], 'url' => ['/option/index', 'tab' => $opt], 'icon' => '<i class="fa fa fa-circle-o"></i>'];
}
$BottmMenu = [
        [
        'label' => Yii::t('rabint', 'سیستم'),
        'options' => ['class' => 'header'],
        'visible' => Yii::$app->user->can('manager')
    ],
        [
        'label' => Yii::t('rabint', 'اختیارات'),
        'icon' => '<i class="fa fa-check-square-o"></i>',
        'options' => ['class' => 'treeview'],
        'url' => '#',
        'visible' => Yii::$app->user->can('manager'),
        'items' => $optionItems,
    ],
        [
        'label' => Yii::t('rabint', 'خط زمانی'),
        'icon' => '<i class="fa fa-bar-chart-o"></i>',
        'url' => ['/timeline-event/index'],
        'badge' => TimelineEvent::find()->today()->count(),
        'badgeBgClass' => 'label-success',
    ],
        [
        'label' => Yii::t('rabint', 'کاربران'),
        'icon' => '<i class="fa fa-users"></i>',
        'url' => ['/user/admin/index'],
        'visible' => Yii::$app->user->can('administrator')
    ],
        [
        'label' => Yii::t('rabint', 'پیکربندی'),
        'url' => '#',
        'icon' => '<i class="fa fa-cogs"></i>',
        'options' => ['class' => 'treeview'],
        'visible' => Yii::$app->user->can('administrator'),
        'items' => [
                ['label' => Yii::t('rabint', 'ذخیره کلید و مقدار'), 'url' => ['/key-storage/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
//            ['label' => Yii::t('rabint', 'File Storage'), 'url' => ['/file-storage/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
            ['label' => Yii::t('rabint', 'کش'), 'url' => ['/cache/index'], 'icon' => '<i class="fa fa fa-circle-o"></i>'],
                [
                'label' => Yii::t('rabint', 'اطلاعات سیستم'),
                'url' => ['/system-information/index'],
                'icon' => '<i class="fa fa fa-circle-o"></i>'
            ],
                [
                'label' => Yii::t('rabint', 'رخداد ها'),
                'url' => ['/log/index'],
                'icon' => '<i class="fa fa fa-circle-o"></i>',
                'badge' => \app\models\SystemLog::find()->count(),
                'badgeBgClass' => 'label-danger',
            ],
                [
                'label' => Yii::t('rabint', 'زمانبدی کارها'),
                'url' => ['/cronjob/index'],
                'icon' => '<i class="fa fa fa-circle-o"></i>',
            ],
            [
                'label' => Yii::t('rabint', 'وقایع کارهای دارای زمانبندی '),
                'url' => ['/cronjob/logs'],
                'icon' => '<i class="fa fa fa-circle-o"></i>',
            ],
             [
                'label' => Yii::t('rabint', 'ویرایشگر'),
                'url' => ['/admin/editor'],
                'icon' => '<i class="fa fa fa-circle-o"></i>',
            ],
        ]
    ]
];

$AllItems = array_merge(array_merge($TopMenu, $ModuleMenu), $BottmMenu);
$r = Yii::$app->request->url;
$b = Yii::$app->request->baseUrl;
$i = 1;
$res = str_replace($b, '', $r, $i);
while (!empty($res)) {
    $find = \rabint\general::arraySearchDeep($AllItems, $res);
    if (!empty($find)) {
        $keys = explode('.', $find);
        $AllItems = tmp_add_class_to_menu($AllItems, $keys);
        break;
    }
    if (strpos($res, '&')) {
        $res = substr($res, 0, strrpos($res, '&'));
    } elseif (strpos($res, '?')) {
        $res = substr($res, 0, strrpos($res, '?'));
    } else {
        $res = substr($res, 0, strrpos($res, '/'));
    }
}
/* =================================================================== */

echo Menu::widget([
    'options' => ['class' => 'sidebar-menu'],
    'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
    'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
    'activateParents' => true,
    'items' => $AllItems
]);

function tmp_add_class_to_menu($array, $keys) {
    $k = array_shift($keys);
    if ($k === false or $k === null or $k === 'url') {
        return $array;
    }
    if (!isset($array[$k]))
        return $array;
    if (isset($array[$k]['options']['class'])) {
        $array[$k]['options']['class'] .= ' active ';
    } elseif (is_array($array[$k])) {
        $array[$k] = array_merge($array[$k], ['options' => ['class' => ' active ']]);
    }
    $array[$k] = tmp_add_class_to_menu($array[$k], $keys);
    return $array;
}
