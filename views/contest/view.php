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
use app\models\Entry;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Contests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="contest-view">
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
                    'trigger',
                    'year',
                    'active:boolean',
                    'last_parse',
                    'parse_from',
                    'parse_to',
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h2><?= Yii::t('app', 'Entries') ?></h2>

        <?php
            if(!Yii::$app->user->isGuest) 
            {
                echo Html::a(
                    Yii::t('app', 'Create {modelClass}', ['modelClass' => 'Entry']), 
                    ['entry/create', 'id' => $model->id], 
                    ['class' => 'btn btn-success']
                );
            }
        ?>


        <?= GridView::widget([
                'dataProvider' => new ActiveDataProvider([
                    'query' => Entry::find()->where(['contest_id' => $model->id]),
                ]),
                'columns' => [
                    [
                        'attribute' => 'contest_entry_id',
                        'format' => 'raw',
                        'value'=> function ($data) { 
                            return Html::a(Html::encode($data->contest_entry_id), ['entry/view', 'id' => $data->id]); 
                        },
                    ],
                    [
                        'attribute' => 'avg_rating',
                        'contentOptions' =>['class' => 'hidden-xs'],
                        'headerOptions' =>['class' => 'hidden-xs'],
                    ],
                    [
                        'attribute' => 'min_rating',
                        'contentOptions' =>['class' => 'hidden-xs'],
                        'headerOptions' =>['class' => 'hidden-xs'],
                    ],
                    'max_rating',
                    'votes',
                    ],
        ]); ?>
    </div>
</div>
