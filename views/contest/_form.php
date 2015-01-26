<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Contest */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contest-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'trigger')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'year')->textInput(['maxlength' => 4]) ?>

    <?= $form->field($model, 'active')->textInput() ?>

    <?= $form->field($model, 'last_parsed_tweet_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'last_parse')->textInput() ?>

    <?= $form->field($model, 'parse_from')->textInput() ?>

    <?= $form->field($model, 'parse_to')->textInput() ?>

    <?= $form->field($model, 'crawler_profile_id')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'custom_regex_entry')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'custom_regex_rating')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'create_time')->textInput() ?>

    <?= $form->field($model, 'update_time')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
