<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use app\models\Tweet;

/* @var $this yii\web\View */
/* @var $model app\models\Entry */

$this->title = Yii::t('app', 'Entry') . " - " . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="row">
    <div class="col-lg-12">
        <div class="entry-view">
            <h1><?= Html::encode($this->title) ?></h1>
            <p>
            <?php
                if(!Yii::$app->user->isGuest) 
                {
                    echo Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']);
                    echo "&nbsp;";
                    echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                            'method' => 'post',
                        ],
                    ]);
                }
            ?>
            </p>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'contest_id',
                        'value' => $model->contest->name
                    ],
                    'avg_rating',
                    'min_rating',
                    'max_rating',
                    'votes',
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h2><?= Yii::t('app', 'Tweets') ?></h2>

        <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => Tweet::find()->where([
                        'entry_id' => $model->id,

                    ]),
                ]),
                'columns' => [
                    [
                        'attribute' => 'user.screen_name',
                        'value'=> function ($data) { 
                            return $data->user->screen_name; 
                        },
                    ],     
                    'created_at:datetime',
                    'text'
                ]
        ]); ?>
    </div>
</div>
