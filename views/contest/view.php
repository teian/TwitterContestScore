<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

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
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'trigger',
                    'year',
                    'active:boolean',
                    'last_parsed_tweet_id',
                    'last_parse',
                    'parse_from',
                    'parse_to',
                    'crawler_profile_id',
                    'custom_regex_entry:ntext',
                    'custom_regex_rating:ntext',
                    'create_time',
                    'update_time',
                ],
            ]) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <h2><?= Yii::t('app', 'Entries') ?></h2>

        <? Pjax::begin(); ?>
        <?= GridView::widget([
                'dataProvider' => new \yii\data\ActiveDataProvider([
                    'query' => app\models\Entry::find(['contest_id' => $model->id]),
                ]),
                'columns' => [
                    [
                        'attribute' => 'contest_entry_id',
                        'format' => 'raw',
                        'value'=> function ($data) { 
                            return Html::a(Html::encode($data->contest_entry_id), ['entry/view', 'id' => $data->id]); 
                        },
                    ],
                    'avg_rating',
                    'min_rating',
                    'max_rating',
                    'votes',
                    ],
        ]); ?>
        <? Pjax::end(); ?>
    </div>
</div>
