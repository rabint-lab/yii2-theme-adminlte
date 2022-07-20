<?php

/**
 * @var $this yii\web\View
 */
use rabint\theme\adminlte\assets\ThemeAsset;
use app\models\TimelineEvent;
use yii\helpers\Html;
use yii\helpers\Url;

$bundle = ThemeAsset::register($this);
?>
<?php $this->beginContent('@theme/views/layouts/base.php'); ?>
<div class="wrapper">
    <!-- header logo: style can be found in header.less -->
    <header class="main-header">
        <a href="<?php echo Yii::getAlias('@appUrl') ?>" target="_BLANK" class="logo">
            <!-- Add the class icon to your logo image or logo icon to add the margining -->
            <?php echo Yii::$app->name ?>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
            <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only"><?php echo Yii::t('rabint', 'Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <?php if (Yii::$app->user->can('administrator')) { ?>
                        <li id="timeline-notifications" class="notifications-menu">
                            <a href="<?php echo Url::to(['/timeline-event/index']) ?>">
                                <i class="fa fa-clock-o"></i>
                                <span class="label label-success">
                                    <?php echo TimelineEvent::find()->today()->count() ?>
                                </span>
                            </a>
                        </li>
                        <?php
                        if (class_exists('\app\modules\post\models\Report')) {
                            $reportCount = \app\modules\post\models\Report::find()->where(['status' => \app\modules\post\models\Report::STATUS_NOTREAD])->count('*');
                            ?>
                            <li id="report-notifications" class="notifications-menu">
                                <a href="<?php echo Url::to(['/post/admin-report/index']) ?>">
                                    <i class="fa fa-warning"></i>
                                    <span class="label label-warning">
                                        <?= $reportCount; ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php
                        if (class_exists('\rabint\contact\models\Contact')) {
                            $contactCount = \rabint\contact\models\Contact::find()->where(['status' => 0])->count('*');
                            ?>
                            <li id="contact-notifications" class="contact-menu">
                                <a href="<?php echo Url::to(['/contact/admin/index']) ?>">
                                    <i class="fa fa-phone"></i>
                                    <span class="label label-info">
                                        <?= $contactCount; ?>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                        <?php
                        if (class_exists('\app\modules\notify\models\Notification')) {
                            $notifyModel = \app\modules\notify\models\Notification::find()->where(['user_id' => NULL, 'read' => app\modules\notify\models\Notification::READ_STATUS_NO]);
                            $notify = $notifyModel->count('*');
                            ?>
                            <li id="notify-dropdown" class="dropdown notifications-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-bell"></i>
                                    <span class="label label-default">
                                        <?= $notify; ?>
                                    </span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="header"><?php echo Yii::t('rabint', 'You have {num} system notification items', ['num' => $notify]) ?></li>
                                    <li>
                                        <!-- inner menu: contains the actual data -->
                                        <ul class="menu">
                                            <?php foreach ($notifyModel->limit(5)->orderby(['id' => SORT_DESC])->all() as $logEntry): ?>
                                                <li>
                                                    <a href="<?php echo Yii::$app->urlManager->createUrl(['/notify/admin/view', 'id' => $logEntry->id]) ?>">
                                                        <i class="fa fa-warning <?php echo $logEntry->priority > 1 ? 'text-red' : 'text-yellow' ?>"></i>
                                                        <?php echo $logEntry->content; ?>
                                                    </a>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </li>
                                    <li class="footer">
                                        <?php echo Html::a(Yii::t('rabint', 'View all'), ['/notify/admin/index']) ?>
                                    </li>
                                </ul>
                            </li>
                        <?php } ?>
                        <!-- Notifications: style can be found in dropdown.less -->
                        <li id="log-dropdown" class="dropdown notifications-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bug"></i>
                                <span class="label label-danger">
                                    <?php echo \app\models\SystemLog::find()->count() ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header"><?php echo Yii::t('rabint', 'You have {num} log items', ['num' => \app\models\SystemLog::find()->count()]) ?></li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php foreach (\app\models\SystemLog::find()->orderBy(['log_time' => SORT_DESC])->limit(5)->all() as $logEntry): ?>
                                            <li>
                                                <a href="<?php echo Yii::$app->urlManager->createUrl(['/log/view', 'id' => $logEntry->id]) ?>">
                                                    <i class="fa fa-warning <?php echo $logEntry->level == \yii\log\Logger::LEVEL_ERROR ? 'text-red' : 'text-yellow' ?>"></i>
                                                    <?php echo $logEntry->category ?>
                                                </a>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </li>
                                <li class="footer">
                                    <?php echo Html::a(Yii::t('rabint', 'View all'), ['/log/index']) ?>
                                </li>
                            </ul>
                        </li>
                    <?php } ?>
                    <!-- User Account: style can be found in dropdown.less -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="user-image">
                            <span><?php echo Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header light-blue">
                                <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" alt="User Image" />
                                <p>
                                    <?php echo Yii::$app->user->identity->username ?>
                                    <small>
                                        <?php //echo Yii::t('rabint', 'Member since {0, date, short}', Yii::$app->user->identity->created_at) ?>
                                    </small>
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('rabint', 'Profile'), ['/user/default/profile'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-left">
                                    <?php echo Html::a(Yii::t('rabint', 'Account'), ['/user/default/index'], ['class' => 'btn btn-default btn-flat']) ?>
                                </div>
                                <div class="pull-right">
                                    <?php echo Html::a(Yii::t('rabint', 'Logout'), ['/user/sign-in/logout'], ['class' => 'btn btn-default btn-flat', 'data-method' => 'post']) ?>
                                </div>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <?php echo Html::a('<i class="fa fa-cogs"></i>', ['/admin/settings']) ?>
                    </li>
                </ul>
            </div>
        </nav>
    </header>
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel -->
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="<?php echo Yii::$app->user->identity->userProfile->getAvatar($this->assetManager->getAssetUrl($bundle, 'img/anonymous.jpg')) ?>" class="img-circle" />
                </div>
                <div class="pull-left info">
                    <p><?php echo Yii::t('rabint', 'Hello, {username}', ['username' => Yii::$app->user->identity->getPublicIdentity()]) ?></p>
                    <a href="<?php echo Url::to(['/sign-in/profile']) ?>">
                        <i class="fa fa-circle text-success"></i>
                        <?php echo Yii::$app->formatter->asDatetime(time()) ?>
                    </a>
                </div>
            </div>
            <!-- sidebar menu: : style can be found in sidebar.less -->
            <?php echo $this->render('_menu'); ?>
        </section>
        <!-- /.sidebar -->
    </aside>

    <!-- Right side column. Contains the navbar and content of the page -->
    <aside class="content-wrapper">
        <?php echo $content ?>
    </aside><!-- /.right-side -->
</div><!-- ./wrapper -->

<?php $this->endContent(); ?>