<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use yii\widgets\DetailView;
use yii\widgets\Pjax;
use app\models\Tweet;
use dosamigos\chartjs\ChartJs;


/* @var $this yii\web\View */
/* @var $model app\models\Entry */

$this->title = Yii::t('app', 'Entry') . " - " . $model->contest_entry_id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Entries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <h1><?= Html::encode($this->title) ?></h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="entry-view">            
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
        <div id="chart">
            <?php                
                $ratings = Tweet::find()
                    ->select(['COUNT(*) AS rating_count', 'rating'])
                    ->where(['entry_id' => $model->id, 'needs_validation' => 0])
                    ->groupBy(['rating'])
                    ->asArray()
                    ->all();

                $chart_labels = [];
                $chart_values = [];

                foreach($ratings as $elem)
                {
                    $chart_labels[] = $elem['rating'];
                    $chart_values[] = $elem['rating_count'];
                }
            ?>
            <?= ChartJs::widget([
                'type' => 'Bar',
                'options' => [
                    'height' => 250,
                ],
                'clientOptions' => [
                    'responsive' => true,
                    'maintainAspectRatio' => false,
                ],
                'data' => [
                    'labels' => $chart_labels,
                    'datasets' => [
                        [
                            'label' => "My Second dataset",
                            'fillColor' => "rgba(151,187,205,0.5)",
                            'strokeColor' => "rgba(151,187,205,1)",
                            'pointColor' => "rgba(151,187,205,1)",
                            'pointStrokeColor' => "#fff",
                            'data' => $chart_values
                        ]
                    ]
                ]
            ]);
            ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h2><?= Yii::t('app', 'Tweets') ?></h2>
        <?php 
            Pjax::begin(['id' => 'tweet-grid']);
            echo GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => Tweet::find()->where(['entry_id' => $model->id, 'needs_validation' => 0]),
                ]),
                'columns' => [
                    [
                        'attribute' => 'user.screen_name',
                        'value'=> function ($data) { 
                            return $data->user->screen_name; 
                        },
                    ],     
                    'rating',
                    'text',
                    'created_at:datetime',
                ]
            ]); 
            Pjax::end();
        ?>
    </div>
</div>
