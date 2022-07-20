<?php

use yii\widgets\Breadcrumbs;

/**
 * @var $this yii\web\View
 */
?>
<?php $this->beginContent('@theme/views/layouts/common.php'); ?>
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $this->title ?>
        <?php if (isset($this->params['subtitle'])): ?>
            <small><?php echo $this->params['subtitle'] ?></small>
        <?php endif; ?>
    </h1>

    <?php
    echo Breadcrumbs::widget([
        'tag' => 'ol',
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ])
    ?>
</section>

<!-- Main content -->
<section class="content">
    <?php foreach (Yii::$app->session->getAllFlashes() as $type => $body) { ?>
        <div class="alert alert-<?= $type; ?> alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
            <?php
            switch ($type) {
                case 'alert':
                case 'danger':
//                            echo '<h4><i class="icon fa fa-ban"></i>'.Yii::t('rabint','اخطار').'</h4>';
                case 'info':
//                            echo '<h4><i class="icon fa fa-info"></i>'.Yii::t('rabint','نکته').'</h4>';
                case 'warning':
//                            echo '<h4><i class="icon fa fa-warning"></i>'.Yii::t('rabint','هشدار').'</h4>';
                case 'success':
//                            echo '<h4><i class="icon fa fa-check"></i>'.Yii::t('rabint','پیام').'</h4>';
            }
            ?>
            <?= print_r($body, TRUE); ?>
        </div>
    <?php } ?>
    <?php echo $content ?>

</section><!-- /.content -->
<?php $this->endContent(); ?>