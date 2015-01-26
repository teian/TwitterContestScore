<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Contests');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="contest-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Contest',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    
    <? Pjax::begin(); ?>
    <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value'=>function ($data) { 
                        return Html::a(Html::encode($data->name), ['contest/view', 'id' => $data->id]); 
                    },
                ],
                'trigger',
                'year',
                'active:boolean',
            ],
    ]); ?>
    <? Pjax::end(); ?>

</div>
