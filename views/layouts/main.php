<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */
 
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

    <section id="container">
        <!-- **********************************************************************************************************************************************************
        TOP BAR CONTENT & NOTIFICATIONS
        *********************************************************************************************************************************************************** -->
        <!--header start-->
        <header  id="header" class="header black-bg">
            <!--
            <div class="sidebar-toggle-box">
                <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
            </div>
            <!--logo start-->
            <a href="<?= Yii::$app->homeUrl ?>" class="logo"><b><?= Yii::$app->params['siteName'] ?></b></a>
            <!--logo end-->

            <div class="top-menu">
                <?php                       
                    echo Nav::widget([
                        'options' => ['class' => 'nav pull-right top-menu'],
                        'items' => [Yii::$app->user->isGuest ?
                            [
                                'label' => 'Login', 
                                'url' => ['/site/login'],
                                'linkOptions' => [
                                    'class' => 'logout',
                                ]
                            ] : [
                                'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                                'url' => ['/site/logout'],
                                'linkOptions' => [
                                    'data-method' => 'post',
                                    'class' => 'logout',
                                ],
                            ],
                        ],
                    ]);                    
                ?>
            </div>
        </header>
      <!--header end-->

        <aside id="sidebar"  class="nav-collapse">
            <!-- sidebar menu start-->
            <?php                            
                echo Nav::widget([
                    'options' => ['class' => 'sidebar-menu', 'id' => 'nav-accordion'],
                    'items' => [
                        ['label' => 'Home', 'url' => ['/site/index']],
                        ['label' => 'Contest', 'url' => ['/contest/index']],
                    ],
                ]);                    
            ?>
            <!-- sidebar menu end-->
        </aside>
        <!--sidebar end-->

        <section id="content" class="wrapper">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <?= $content ?>
                    </div>
                </div>
            </div>
        </section>

        <!--main content end-->
        <!--footer start-->
        <footer id="footer">
            <div class="text-center">&copy; Twitter Contest Score <?= date('Y') ?></div>
        </footer>
        <!--footer end-->
    </section>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
