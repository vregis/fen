<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use backend\components\SidebarWidget;
use common\models\Orders;
use common\models\Reviews;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="skin-blue sidebar-mini">
    <?php $this->beginBody() ?>
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="<?= Yii::$app->homeUrl?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>A</b>LT</span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>Admin</b>LTE</span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle">
                                Сегодня <?= Yii::$app->formatter->asDate(date('Y-m-d'))?>
                            </a>
                        </li>
                        <li class="dropdown notifications-menu">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
                                Отзывы
                                <span class="label label-warning"><?= Reviews::getNewReviews()?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Новые отзывы</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php if($reviews = Reviews::getNewReviewsList()){
                                            foreach($reviews as $review){?>
                                                <li>
                                                    <a href="<?= Url::toRoute('/reviews/update/'.$review['id'])?>">
                                                        <i class="fa fa-user text-red"></i> Отзывы от: «<?= $review['name']?>»
                                                    </a>
                                                </li>
                                            <?php }
                                        }?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="<?= Url::toRoute('/reviews')?>">Смотреть все</a></li>
                            </ul>
                        </li>
                        <li class="dropdown notifications-menu">
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="true">
                                Заявки
                                <span class="label label-warning"><?= Orders::getNewOrders()?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Новые заявки</li>
                                <li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class="menu">
                                        <?php if($orders = Orders::getNewOrdersList()){
                                            foreach($orders as $order){?>
                                                <li>
                                                    <a href="<?= Url::toRoute('/orders/update/'.$order['id'])?>">
                                                        <i class="fa fa-user text-red"></i> Заявка на: «<?= Html::tag('b', Orders::getRoomName($order['room_id']))?>»
                                                    </a>
                                                </li>
                                            <?php }
                                        }?>
                                    </ul>
                                </li>
                                <li class="footer"><a href="<?= Url::toRoute('/orders')?>">Смотреть все</a></li>
                            </ul>
                        </li>
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?= Html::img('@lte_images/user2-160x160.jpg', ['class' => 'user-image', 'alt' => 'User Image'])?>
                                <span class="hidden-xs"><?= Yii::$app->user->identity->name?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <?= Html::img('@lte_images/user2-160x160.jpg', ['class' => 'img-circle', 'alt' => 'User Image'])?>
                                    <p>
                                        <?= Yii::$app->user->identity->name?>
                                        <small>Сегодня <?= Yii::$app->formatter->asDate(date('Y-m-d'))?></small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <?= Html::a('Профиль',Url::toRoute('/site/profile'),['class' => 'btn btn-default btn-flat']) ?>
                                    </div>
                                    <div class="pull-right">
                                        <?= Html::a('Выйти',Url::toRoute('/site/logout'),['data-method' => 'post', 'class' => 'btn btn-default btn-flat']) ?>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <?= SidebarWidget::widget([
                    'moduleId' => $this->context->module->id
                ])?>
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content">
                <?= $content?>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Light version</b> 0.0.1
            </div>
            <strong>&copy; <a href="#">АКК</a>.</strong> Все права защищены.
        </footer>

        <div class="control-sidebar-bg"></div>
    </div><!-- ./wrapper -->
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
