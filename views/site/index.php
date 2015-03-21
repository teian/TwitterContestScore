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
        <h1><?= Yii::t('app', 'Welcome to the') ?> <i><?= Html::encode($this->title); ?></i>!</h1>

        <p class="lead"><?= Yii::t('app', 'Automated scoring for our beloved contest.') ?></p>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
                
            </div>
        </div>
    </div>
</div>
