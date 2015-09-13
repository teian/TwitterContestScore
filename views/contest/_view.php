<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\widgets\DetailView;
?>

<h3><?= Html::a(Html::encode($model->name), ['contest/view', 'id' => $model->id]) ?></h3>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'trigger',
        'year',
        'active:boolean',
        'last_parse',
    ],
]) ?>