<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Tweet */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Tweet',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Tweets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tweet-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
