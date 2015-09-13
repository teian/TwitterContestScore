<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php
            if(!Yii::$app->user->isGuest) 
            {
                echo Html::a(
                    Yii::t('app', 'Create {modelClass}', ['modelClass' => 'Contest',]), 
                    ['create'], 
                    ['class' => 'btn btn-success']
                );
            }
        ?>
    </p>

    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => '_view',
    ]) ?>    

</div>
