<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Tweet */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tweet-form">

    <?php $form = ActiveForm::begin(); ?>

    <p><?= Html::encode($model->text) ?></p>

    <p><?= Html::encode($model->user->screen_name) ?></p>

    <?= $form->field($model, 'contest_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'entry_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'rating')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'needs_validation')->textInput() ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
