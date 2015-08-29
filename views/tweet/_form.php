<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;
use kartik\widgets\DepDrop;
use app\models\Contest;
use app\models\Entry;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */
/* @var $form yii\widgets\ActiveForm */

$list = [];
?>

<div class="tweet-form">

    <?php $form = ActiveForm::begin(); ?>

    <h2>@<?= Html::encode($model->user->screen_name) ?></h2>

    <p class="well well-sm"><?= Html::encode($model->text) ?></p>  

    <?= $form->field($model, 'contest_id')->widget(Select2::classname(), [
        'data' => ArrayHelper::map(Contest::find()->all(), 'id', 'name'),
        'options' => ['placeholder' => 'Select a Contest ...'],
        'pluginOptions' => [
            'allowClear' => true
        ],
    ]); ?>

    <?= $form->field($model, 'entry_id')->widget(DepDrop::classname(), [
        'data' => ArrayHelper::map(Entry::find()->where(['contest_id' => $model->contest_id])->all(), 'id', 'name'),
        'options' => ['placeholder' => Yii::t('app','Select a Entry ...')],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options'=>['pluginOptions'=>['allowClear'=>true]],
        'pluginOptions'=>[
            'depends'=>['tweet-contest_id'],
            'url' => Url::to(['/entry/contest-entries']),
            'loadingText' => Yii::t('app','Loading Entries ...'),
        ]
    ]); ?>

    <?= $form->field($model, 'rating')->textInput(['maxlength' => 4]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
