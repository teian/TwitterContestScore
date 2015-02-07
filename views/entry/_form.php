<?php
/**
 * @author Frank Gehann <fg@randomlol.de>
 * @link https://github.com/Tak0r/TwitterContestScore
 * @license Beerware
 * @package Views
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Entry */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="entry-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'contest_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'contest_entry_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'avg_rating')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'min_rating')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'max_rating')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'sum_rating')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'votes')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
