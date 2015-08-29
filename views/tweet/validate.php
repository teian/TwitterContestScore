<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Tweets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-validate">

    <h1><?= Html::encode($this->title) ?></h1>
    
    <? Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'user_id',
                'value'=> function ($data) { 
                    return $data->user->screen_name; 
                },
            ],
            'text',
            'contest_id',
            [
                'attribute' => 'contest_id',
                'value'=> function ($data) { 
                    return $data->contest->name; 
                },
            ],
            'rating',
            'created_at',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <? Pjax::end(); ?>

</div>