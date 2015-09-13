<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */
 
use yii\helpers\Html;

/* @var $this yii\web\View */
$this->title = Yii::t('app', 'Twitter Contest Score');
?>
<div class="site-index">

    <div class="jumbotron">
        <h2><?= Yii::t('app', 'Welcome to the') ?> <?= Html::encode($this->title); ?>!</h2>

        <p class="lead"><?= Yii::t('app', 'Automated Twitter scoring.') ?></p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>
