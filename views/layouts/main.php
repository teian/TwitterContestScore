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
<html>
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/img/favicon.ico" type="image/x-icon"> 
    <link rel="shortcut icon" href="<?= Yii::getAlias('@web') ?>/img/favicon.png" type="image/png">
    <link rel="apple-itouch-icon" href="<?= Yii::getAlias('@web') ?>/img/favicon.png"> 
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<header class="navbar navbar-inverse navbar-fixed-top" id="top" role="banner">
  <div class="container">
    <div class="navbar-header">
      <button class="navbar-toggle collapsed" type="button" data-toggle="collapse" data-target="#bs-navbar" aria-controls="bs-navbar" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a href="<?= Yii::$app->homeUrl ?>" class="navbar-brand"><?= Yii::$app->params['siteName'] ?></a>
    </div>
    <nav id="bs-navbar" class="collapse navbar-collapse">
        <?php 
            $main_menu = [
                [
                    'label' => 'Home', 
                    'url' => ['/site/index']
                ], [
                    'label' => 'Contest', 
                    'url' => ['contest/index'],
                    'active' => (Yii::$app->controller instanceof app\controllers\ContestController || Yii::$app->controller instanceof app\controllers\EntryController) ? true : false
                ]
            ];

            if(!Yii::$app->user->isGuest) {
                array_push($main_menu, ['label' => 'Validate Tweets', 'url' => ['/tweet/validate']]);
            }

            echo Nav::widget([
                'options' => ['class' => 'nav navbar-nav'],
                'activateParents' => true,
                'items' => $main_menu,
            ]);  

            echo Nav::widget([
                'options' => ['class' => 'nav navbar-nav navbar-right'],
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
    </nav>
  </div>
</header>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <?= 
               Breadcrumbs::widget([
                  'homeLink' => [ 
                                  'label' => Yii::t('yii', 'Home'),
                                  'url' => Yii::$app->homeUrl,
                             ],
                  'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
               ]) 
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <?= $content ?>
        </div>
    </div>
</div>
<footer id="footer">
    <div class="text-center">&copy; Twitter Contest Score <?= date('Y') ?></div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
